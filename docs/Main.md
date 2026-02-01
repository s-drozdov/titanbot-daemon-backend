<p align="center">
    <h2 align="center">Backend for Titanbot Daemon</h2>
</p>
<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars.githubusercontent.com/u/143937?s=100&v=4" alt="Symfony Logo">
    </a>
    <h3 align="center">php8.4 - Symfony 8.0.5</h3>
    <br>
</p>

The project was developed using a Test First approach in combination with Domain-Driven Design principles.

### Stages of development

At the initial stage, a domain model was established based on the technical requirements, identifying core entities and aggregates, defining their consistency boundaries, and formalizing domain relationships and invariants.

![](docs/img/aggregates.png)

Next, end-to-end tests were created to reflect the complete system lifecycle and to cover the core domain business logic. These tests captured the expected system behavior from the perspective of domain scenarios.

After that, the application and infrastructure code was implemented iteratively, strictly driven by the requirements defined in the tests. This ensured alignment between the implementation and the domain model, as well as the system’s resilience to change.

### Daemon database

The daemon’s operation directly depends on a local SQLite database, which defines its behavior.
The daemon’s database is an exported subset of the main database that must always be available to the daemon and kept up to date.

To avoid exporting the database on every request, it is necessary to reliably determine whether any changes have occurred. One possible approach would be to verify a checksum for the requested filter, but this is undesirable due to the resource cost, especially since version checks are likely to be the most frequent requests.

Therefore, instead of recalculating a row-by-row checksum across all exported tables for each request, it is sufficient to retrieve the most recent updated_at value among the results of the export filter and use it as the change indicator.

### Security

Authentication in the service is intentionally simple and is based on API tokens provided via the X-API-KEY header. There are two types of tokens:
- **Admin token**: there is always exactly one admin token. It is stored in Vault, periodically rotated, and grants full read/write access. All requests using this token are executed внутри the cluster, within a single node. These requests never interact with the public network.
- Client token (**DaemonToken**): these tokens are stored and rotated in the database and have a short time-to-live. 

The daemon backend operates as two replica sets. The first replica set runs in RO mode and provides public access for clients using daemon tokens. The second replica set runs with full administrative access but is reachable only via an internal cluster service. All requests to this replica set go through an administrative backend middleware using the admin token. External access to the administrative backend is allowed only via OAuth 2.0

![](docs/img/security.png)
