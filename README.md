# WordPress SFX
Builds a self-extracting single PHP script WordPress archive for easy deployment on shared hosting with limited access. The archive extracts WordPress and deletes itself. For security reason, the archive is limited to 24 hour validity period (as measured by file mtime), after which it deactivates itself.

Expect the file to be about 27MB size.

Be sure to run wordpress update after the deployment.
