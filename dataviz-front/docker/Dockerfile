# Build Stage
FROM node:22.14-alpine AS builder

WORKDIR /app
ENV PATH=/node_modules/.bin:$PATH

COPY package.json yarn.lock ./

RUN yarn install --frozen-lockfile

COPY . .

RUN yarn build

# Development Stage (with hot reload)
FROM node:22.14-alpine AS dev

WORKDIR /app
ENV PATH /node_modules/.bin:$PATH

COPY --from=builder /app/node_modules node_modules
COPY --from=builder /app/package.json package.json
COPY --from=builder /app/yarn.lock yarn.lock
COPY . .

EXPOSE 5173
CMD ["yarn", "dev"]

# Production Stage
FROM nginx:1.27.4-alpine AS prod

COPY --from=builder /app/dist /usr/share/nginx/html

EXPOSE 5173
CMD ["nginx", "-g", "daemon off;"]
