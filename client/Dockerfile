FROM node:16.14.2-alpine

RUN mkdir -p /usr/src/fonky-client
WORKDIR /usr/src/fonky-client

RUN apk update && apk upgrade
RUN apk add git

COPY . /usr/src/fonky-client/
RUN yarn

EXPOSE $CLIENT_PORT

ENV NUXT_HOST=0.0.0.0
ENV NUXT_PORT=$CLIENT_PORT

CMD [ "yarn", "dev" ]
