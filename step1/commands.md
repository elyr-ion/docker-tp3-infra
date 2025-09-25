docker network create tp3-net

docker run -d \
  --name script \
  --network tp3-net \
  -v $(pwd)/app:/app \
  php:8.2-fpm

docker run -d \
  --name http \
  --network tp3-net \
  -p 8080:8080 \
  -v $(pwd)/app:/app \
  -v $(pwd)/nginx/default.conf:/etc/nginx/conf.d/default.conf \
  nginx:alpine

