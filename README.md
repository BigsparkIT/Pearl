## Installation

1. Start the containers with `docker compose up -d`.
2. Open the Node container, you should be in the Pearl directory.
3. In the Node container do `npm install`.
4. Go to `localhost:8080` and initialise a wordpress site.
5. Go edit a page and check that you can make a block with `/Product Iframe`.

## Developement
- Open the Node container, you should be in the Pearl directory.
- Use `npm run start` to automatically keep the build files up to date with the src files.
- Use `npm run build` to manually update the build files from the src files.