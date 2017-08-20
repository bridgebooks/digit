FROM kibana:4

RUN apt-get update && apt-get install -y netcat

COPY entrypoint.sh /tmp/entrypoint.sh
RUN chmod +x /tmp/entrypoint.sh

RUN kibana plugin --install elastic/sense
RUN kibana plugin -i kibi_wordcloud_vis -u https://github.com/sirensolutions/kibi_wordcloud_vis/raw/4.5.3/target/kibi_wordcloud_vis-4.5.3.zip
RUN kibana plugin -i kibi_timeline_vis -u https://github.com/sirensolutions/kibi_timeline_vis/raw/4.6.3-1/target/kibi_timeline_vis-4.6.3-1.zip
RUN kibana plugin -i kibana_ext_metrics_vis -u https://github.com/ommsolutions/kibana_ext_metrics_vis/releases/download/0.1.0/extended_metric_vis.zip
RUN kibana plugin --install x-packs -u https://artifacts.elastic.co/downloads/kibana-plugins/x-pack/x-pack-5.0.0.zip
RUN kibana plugin --install logtrail -u https://github.com/sivasamyk/logtrail/releases/download/0.1.7/logtrail-4.x-0.1.7.tar.gz


CMD ["/tmp/entrypoint.sh"]


