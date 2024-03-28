FROM node:lts-alpine as build-stage

# set the working directory
WORKDIR /var/www/html/

# Copy the working directory in the container
COPY package*.json ./

# Install the project dependecies
# if you npm then npm install
RUN yarn install

# Copy the rest of the project files to the container
COPY . .

#Build the Vue.js application to the production mode to dist folder
# here also if you use npm then npm run build
RUN yarn build

EXPOSE 8080
CMD [ "npm", "run", "serve" ]
