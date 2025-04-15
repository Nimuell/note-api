# Notes API

Jednoduchá API aplikace pro správu poznámek s různými prioritami.

## Instalace a spuštění

### Instalace pomocí Dockeru

1. Naklonujte repozitář:

```bash
git clone <https://github.com/Nimuell/note-api>
```

2. Spusťte aplikaci pomocí Docker Compose:

```bash
# Sestavení a spuštění kontejnerů
docker compose up -d --build
docker compose exec php composer install
```

3. Vytvořte tabulky přímo v databázi:

```bash
# Sestavení a spuštění kontejnerů
docker compose exec php php bin/console doctrine:database:create --if-not-exists

docker compose exec php php bin/console doctrine:migrations:migrate
```
   

4. Aplikace je nyní dostupná na adrese `http://localhost:8080/api`

5. Pro zastavení všech kontejnerů:

```bash
docker compose down
```

Pro zachování dat v databázi při zastavení:

```bash
docker compose down --volumes
```

## API Dokumentace

Automaticky generovaná interaktivní dokumentace je dostupná na:

- Swagger UI: `http://localhost:8080/api/docs` 
- ReDoc: `http://localhost:8080/api/docs.html`

Tyto nástroje umožňují procházet a testovat API endpointy přímo z prohlížeče.

## Důležité poznámky k použití API

### Content-Type hlavičky

API Platform vyžaduje specifické hlavičky pro správné zpracování požadavků:

- Pro čtení dat (GET) používejte: `Accept: application/ld+json`
- Pro zápis dat (POST, PUT) používejte: `Content-Type: application/ld+json`
- Pro částečnou aktualizaci (PATCH) používejte: `Content-Type: application/merge-patch+json`

Použití nesprávné hlavičky (např. běžné `application/json`) povede k chybě 415 Unsupported Media Type.

### Příklady použití API

#### Získání seznamu všech poznámek
```bash
curl -H "Accept: application/ld+json" http://localhost:8080/api/notes
```

#### Vytvoření nové poznámky
```bash
curl -X POST -H "Content-Type: application/ld+json" -H "Accept: application/ld+json" \
  -d '{"name":"Testovací poznámka", "text":"Toto je testovací poznámka.", "priority":"high"}' \
  http://localhost:8080/api/notes
```

#### Filtrování poznámek podle priority
```bash
curl -H "Accept: application/ld+json" http://localhost:8080/api/notes?priority=high
```

Tímto způsobem získáte pouze poznámky s vysokou prioritou. Dostupné hodnoty pro filtr jsou:
- `priority=low` - poznámky s nízkou prioritou
- `priority=medium` - poznámky se střední prioritou
- `priority=high` - poznámky s vysokou prioritou

## Klíčové designové volby

### Technologie

- **Symfony Framework**: Framework byl zvolen pro svou robustnost, flexibilitu a rozsáhlou dokumentaci.
  
- **API Platform**: Rychlý vývoj REST API. API Platform automaticky generuje CRUD operace, dokumentaci a umožňuje snadnou konfiguraci API endpointů.

- **Doctrine ORM**: Umožňuje pracovat s databázovými entitami jako s objekty v PHP.

- **MariaDB**: Requirement zadání.

- **Docker**: Pro snadné nasazení a konzistentní vývojové prostředí používáme Docker kontejnery, které izolují aplikaci a její závislosti.

### Architektura

- **REST API**: Standardizovaný přístup k datům a umožňuje integraci s různými frontend technologiemi.

- **PHP Enum**: Poskytuje typově bezpečný způsob reprezentace pevné sady hodnot.

- **Repository**: Odděluje business logiku od datové vrstvy.

## Struktura entity Notes

Entity Notes má následující vlastnosti:

| Vlastnost | Typ     | Popis                                        |
|-----------|---------|----------------------------------------------|
| id        | int     | Automaticky generované ID záznamu            |
| name      | string  | Název poznámky (max 255 znaků)               |
| text      | text    | Text/obsah poznámky                          |
| priority  | enum    | Priorita poznámky (low, medium, high)        |
