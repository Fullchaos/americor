build:
	docker-compose up -d --build

start:
	UID="$(id -u)" GID="$(id -g)" docker-compose up -d

restart:
	docker-compose restart

down:
	UID="$(id -u)" GID="$(id -g)" docker-compose down

stop:
	docker-compose stop