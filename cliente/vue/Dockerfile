FROM nginx:1.17-alpine

COPY config/default.conf /etc/nginx/conf.d/
COPY config/proxy.conf /etc/nginx/
COPY config/env.sh /etc/nginx/

ADD  dist.tar.gz /usr/share/nginx/html/

RUN npm run build

RUN cd dist
RUN tar zcvf dist.tar.gz *
RUN mv dist.tar.gz ../

CMD ["sh", "-c", "/etc/nginx/env.sh ; nginx -g 'daemon off;'"]