up:
	docker compose up -d

down:
	docker compose down

install:
	docker exec -it node npm install

start:
	docker exec -it node npm run start

build:
	docker exec -it node npm run build
