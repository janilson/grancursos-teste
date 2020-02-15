FROM nginx:1.17-alpine

COPY config/default.conf /etc/nginx/conf.d/
COPY config/proxy.conf /etc/nginx/
COPY config/env.sh /etc/nginx/

ADD  dist.tar.gz /usr/share/nginx/html/

CMD ["sh", "-c", "/etc/nginx/env.sh ; nginx -g 'daemon off;'"]