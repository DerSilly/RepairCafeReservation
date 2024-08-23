docker network create laravel-network
docker volume create --name mariadb_data
docker run -d --name mariadb `
    -p 3306:3306 `
    --env MARIADB_USER=bn_myapp `
    --env MARIADB_DATABASE=repaircafemanagementsystem `
    --env MARIADB_ROOT_PASSWORD=password `
    --env MARIADB_PASSWORD=password `
    --network laravel-network `
    --volume mariadb_data:/repaircafemanagementsystem_db `
    bitnami/mariadb:11.4.2
docker run -d --name laravel `
    -p 8000:8000 `
    --env DB_HOST=mariadb `
    --env DB_PORT=3306 `
    --env DB_USERNAME=root `
    --env DB_PASSWORD=password `
    --env DB_DATABASE=repaircafemanagementsystem `
    --network laravel-network `
    --volume ${PWD}/my-project:/app `
    bitnami/laravel:11.1.4