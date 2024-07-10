# Phluent

## Query

The purpose of Query is to act as a container for the clause types, provide
methods to add new data and then render the sql from the clauses.

## Changes

### Select

Selects can be column references, functions, casts, or Closures. Allow complex
input by not bothering to sanity check and do away with the need to SelectDistinct
aggregates like max, min and other abominations.


### Join

Joins are either closures or table references, will guess the column references
from the table names if not provided.


### OrderBy, GroupBy

These are just lists of column references. Order by may also include a direction.

### Limit, Offset

Limit and offset remain the same.

### Insert, Update, Truncate

These queries should check if any other parameters are filled, they should only
require a table name, if any other params are set then throw error.

### Unions

Should this be a separate function? union(Query, Query, Query)


### Other changes

Query should be castable to string (getSql)
Query should be castable to array (getParams)

toString()
toArray()

Parameter handling
