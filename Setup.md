sudo pacman -S docker
sudo systemctl start docker.service
sudo systemctl enable docker.service
sudo usermod -aG docker $USER

#export SECRET_1=$(bws secret get fc3a93f4-2a16-445b-b0c4-aeaf0102f0ff | jq '.value')

mkdir ${PWD}/repairdb_data
docker network create repaircafe-network
docker volume create --name repairdb_data

docker run --name repairdb \
  -p 3306:3306 \
  --env ALLOW_EMPTY_PASSWORD=yes \
  --env MARIADB_USER=repair_admin \
  --env MARIADB_DATABASE=repaircafe \
  --network repaircafe-network \
  --volume ${PWD}/repairdb_data:/bitnami/mariadb \
  bitnami/mariadb:latest

#to start from Scratch delete the content of the API-folder befor running docker run

docker run --name repaircafe \
  -p 8000:8000 \
  --env DB_HOST=repairdb \
  --env DB_USERNAME=repair_admin \
  --env DB_DATABASE=repaircafe \
  --network  repaircafe-network \
  --volume ${PWD}/API:/app \
  bitnami/laravel:latest