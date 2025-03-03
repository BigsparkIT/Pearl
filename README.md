## Installation

1. Start the containers with `docker compose up -d`.
2. Open the Node container, you should be in the Pearl directory.
3. In the Node container do `npm install`.
4. Go to `localhost:8080` and initialise a wordpress site.
5. Go edit a page and check that you can make a block with `/Product Iframe`.

At the moment, connecting to staging Starfish is not yet possible, so to connect to local Starfish:

1. In Wordpress admin, go to Settings -> Pearl and fill in an existing platform identifier like `ANDROIDWORLDNL`.
2. Start Starfish local and in Starfish `platforms/platforms.ts` add `http://localhost:8080` to the frameAncestor of the platform(s) you want to use.
3. Check that the iframeUrl in Pearl `index.js` points to localhost.
4. The preview should now work.

## Developement
- Open the Node container, you should be in the Pearl directory.
- Use `npm run start` to automatically keep the build files up to date with the src files.
- Use `npm run build` to manually update the build files from the src files.