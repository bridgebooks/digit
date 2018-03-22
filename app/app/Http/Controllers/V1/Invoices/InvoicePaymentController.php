<?php

namespace App\Http\Controllers\V1\Invoices;

use App\Models\Invoice;
use App\Models\OrgBankAccount;
use App\Models\Bank;

use App\Events\InvoiceCardPaymentInit;
use App\Events\InvoiceCardPaymentVerify;
use App\Events\InvoiceCardPaymentVerifyFail;

use Emmanix2002\Moneywave\Moneywave;
use Emmanix2002\Moneywave\Enum\PaymentMedium;
use Emmanix2002\Moneywave\Enum\AuthorizationType;
use Emmanix2002\Moneywave\Exception\ValidationException;

use App\Http\Controllers\V1\Controller;
use App\Http\Requests\V1\InitPayment;
use App\Http\Requests\V1\VerifyPayment;

use App\Repositories\InvoiceRepository;
use App\Repositories\InvoicePaymentRepository;
use GuzzleHttp\Psr7\Request;

class InvoicePaymentController extends Controller
{
	protected $invoiceRepository;
	protected $invoicePaymentRepository;
	protected $moneywave;
	protected $params = [
		'first_name',
		'last_name',
		'email',
		'phone',
		'card_no',
		'cvv',
		'expiry_month',
		'expiry_year',
		'pin'
	];

	public function __construct
	(
		InvoiceRepository $invoiceRepository,
		InvoicePaymentRepository $invoicePaymentRepository,
		Moneywave $moneywave
	)
	{
		$this->invoiceRepository = $invoiceRepository;
		$this->invoicePaymentRepository = $invoicePaymentRepository;
		$this->moneywave = $moneywave;
	}

	private function initCardToAccountTransaction(array $params, OrgBankAccount $account, Bank $bank, Invoice $invoice)
	{
		try {
			$cardToAccount = $this->moneywave->createCardToBankAccountService();
			$cardToAccount->firstname = $params['first_name'];
			$cardToAccount->lastname = $params['last_name'];
			$cardToAccount->phonenumber = $params['phone'];
			$cardToAccount->email = $params['email'];
			$cardToAccount->recipient_bank = $bank->identifier;
			$cardToAccount->recipient_account_number = $account->account_number;
			$cardToAccount->card_no = $params['card_no'];
			$cardToAccount->cvv = $params['cvv'];
			$cardToAccount->expiry_year = $params['expiry_year'];
			$cardToAccount->expiry_month = $params['expiry_month'];
			$cardToAccount->amount = $invoice->total;
			$cardToAccount->fee = 0;
			$cardToAccount->narration = 'Payment for '.$invoice->invoice_no;
			$cardToAccount->redirecturl = config('mw.callback_url');
			$cardToAccount->medium = PaymentMedium::WEB;
			$cardToAccount->pin = $params['pin'];

			$response = $cardToAccount->send();

			return $response;
		} catch (ValidationException $e) {
			return $e->getMessage();
		}
	}

	private function initCardToAccountValidation(array $params)
	{
		try {
			$validateTransfer = $this->moneywave->createValidateCardTransferService();
			$validateTransfer->transactionRef = $params['transaction_ref'];
			$validateTransfer->otp = $params['otp'];

			$response = $validateTransfer->send();

			return $response;
		} catch (ValidationException $e) {
			return $e->getMessage();
		}
	}

    /**
     * @param Request $request
     * @param string $id
     * @return mixed
     */
    public function get(string $id)
    {
        return $this->invoicePaymentRepository->find($id);
    }

	public function init(InitPayment $request, string $id)
	{
		$params = $request->only($this->params);
		// get invoice and invoice settings
		$invoice = $this->invoiceRepository->skipPresenter()->find($id);
		$invoiceSettings = $invoice->org->invoiceSettings;

		if (!$invoiceSettings->org_bank_account_id) {
			return response()->json([
				'status' => 'error',
				'message' => 'No account set to recieve payments'
			], 400);
		}

		$account = $invoiceSettings->bankAccount;
		$bank = $account->bank;

		$requestResponse = $this->initCardToAccountTransaction($params, $account, $bank, $invoice);

		if (empty($requestResponse->getMessage())) {
			event(new InvoiceCardPaymentInit($invoice, $requestResponse, $params));

			return response()->json($requestResponse->getData());
		}

		return repsonse()->json([
			'status' => 'error',
			'message' => $requestResponse->getMessage()
		], 400);
	}

	public function verify(VerifyPayment $request, string $id)
	{
		$params = $request->only(['transaction_ref', 'otp']);
		// get invoice and invoice settings
		$invoice = $this->invoiceRepository->skipPresenter()->find($id);

		$requestResponse = $this->initCardToAccountValidation($params);

		if (empty($requestResponse->getMessage())) {
			event(new InvoiceCardPaymentVerify($invoice, $params, $requestResponse));

			return response()->json($requestResponse->getData());
		}

		event(new InvoiceCardPaymentVerifyFail($invoice, $params, $requestResponse));

		return response()->json([
			'status' => 'error',
			'message' => $requestResponse->getMessage()
		], 400);
	}
}