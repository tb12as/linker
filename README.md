# Linker Project
Free link sharer api

## API Documentation

<table><tbody><tr><td><strong>Enpoint</strong></td><td><strong>Method</strong></td><td><strong>Parameter / Body</strong></td><td><strong>Description</strong></td></tr><tr><td>/api/link/get-{type}</td><td>GET</td><td>$type (string, required, in:random, latest, popular)</td><td>Get links by type</td></tr><tr><td>/api/link/get/{code}</td><td>GET</td><td>$code (required)</td><td>Get a link by the code</td></tr><tr><td>/api/link/search/{query}</td><td>GET</td><td>$query (required, min:3)</td><td>Search link&nbsp;</td></tr><tr><td>/api/link/create</td><td>POST</td><td>$link (required), $title (required)</td><td>Create new link</td></tr></tbody></table>

