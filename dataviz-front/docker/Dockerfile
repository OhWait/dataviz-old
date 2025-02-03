FROM node:20 as builder

WORKDIR /app
ENV PATH /node_modules/.bin:$PATH

ARG VITE_BACKEND_URL
ENV VITE_BACKEND_URL=$VITE_BACKEND_URL

COPY package.json yarn.lock ./

RUN yarn install --frozen-lockfile

COPY . .

RUN yarn build

FROM node:latest as dev

WORKDIR /app
ENV PATH /node_modules/.bin:$PATH

COPY package.json yarn.lock ./
RUN yarn install --frozen-lockfile

COPY . .

EXPOSE 5173
CMD ["yarn", "dev"]

FROM nginx:latest as prod

COPY --from=builder /app/dist /usr/share/nginx/html

EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]
