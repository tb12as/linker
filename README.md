# Linker Project
Free link sharer api

## API Documentation

<table>
    <tbody>
        <tr>
            <td><strong>Enpoint</strong></td>
            <td><strong>Method</strong></td>
            <td><strong>Parameter / Body</strong></td>
            <td><strong>Description</strong></td>
            <td><strong>Auth Required</strong></td>
        </tr>
        <tr>
            <td>/api/link/get-{type}</td>
            <td>GET</td>
            <td>type (string, required, in:random, latest, popular)</td>
            <td>Get links by type</td>
            <td>false</td>
        </tr>
        <tr>
            <td>/api/link/get/{code}</td>
            <td>GET</td>
            <td>code (required)</td>
            <td>Get a link by the code</td>
            <td>false</td>
        </tr>
        <tr>
            <td>/api/link/search/{query}</td>
            <td>GET</td>
            <td>query (required, min:3)</td>
            <td>Search link</td>
            <td>false</td>
        </tr>
        <tr>
            <td>/api/link/create</td>
            <td>POST</td>
            <td>
                <ul>
                    <li>link (required)</li>
                    <li>title (required)</li>
                </ul>
            </td>
            <td>Create new link</td>
            <td>false</td>
        </tr>
         <tr>
            <td>/api/link/mine</td>
            <td>GET</td>
            <td>
                <ul>
                    <li>page (numeric, min:1)</li>
                    <li>search (nullable)</li>
                </ul>
            </td>
            <td>Get current logged in account links</td>
            <td>true</td>
        </tr>
    </tbody>
</table>

## Todo
- [ ] Public short link create
- [ ] Register
- [ ] Logout (revoke token)
- [ ] Add more API documentation
