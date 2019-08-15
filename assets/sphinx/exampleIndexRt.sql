# Example of SQL for indexing rows

SELECT
    x.id,
    x.id 'attr_id',
    x.deleted 'attr_deleted',
    UNIX_TIMESTAMP(x.datetime_edited) AS 'attr_datetime_edited',
    x.title 'title'
FROM example x
GROUP BY x.id
