#!/bin/bash

set -e

#echo "🔧 Actualizando repositorio..."
#git pull
#echo "✅ Repositorio actualizado."

#echo "🔧 Creando imagen base..."
#docker build -f docker/Dockerfile.base -t $IMAGE_NAME .
#echo "✅ Imagen base creada."

echo "🚀 Ejecutando docker-compose up..."
docker compose -f docker-compose-prod.yml up --build -d
echo "✅ Contenedores ejecutados."

echo "🔄 Limpiando imágenes no utilizadas..."
docker image prune -f
echo "✅ Imágenes no utilizadas eliminadas."

echo "Sistema iniciado correctamente."
