<?php
// Open a connection to an SQLite database stored in filename: $db_filename.
// Returns: Connection to database.
function open_sqlite_db($db_filename)
{
  if (!file_exists($db_filename)) {
    throw new Exception('Failed to open database. No such file: ' . $db_filename);
  }

  // database was already initialized. Just open it!
  $db_connection = new PDO('sqlite:' . $db_filename);
  $db_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  return $db_connection;
}

// Execute a query ($sql) against a database ($db).
// Returns query results if query was successful.
// Returns NULL if query was not successful.
function exec_sql_query($db, $sql, $params = array())
{
  error_log('  executing SQL: ' . $sql);

  $query = $db->prepare($sql);
  if ($query and $query->execute($params)) {
    return $query;
  }
  return NULL;
}
