FROM nginx:1.14 as base

FROM base as development

FROM base as production
COPY ./docker/nginx/server.conf /etc/nginx/conf.d/app.conf
