
# Exports

In this directory, we have export excel functions. In all of files that exists in this directory, the data get from related session. the session is set after import. sow if you want to change export collection, go to related import file.

for example: if you want to change plan duplicate collection go to `PlanImport.php` file then check `duplicates` property of this class.


## Duplicate Plans Export

The `DuplicatePlansExport.php` duty is export duplicated plans from imported excel file.

## Error Plans Export

The `ErrorPlansExport.php` duty is export plans that it's performer's nationality code is empty.

## Address\Empty Nationality Code Export

The `EmptyNationalityCodeExport.php` duty is export addresses that it's performer's nationality code is empty.

## Address\Not Found Export
The `NotFoundExport.php` duty is export addresses that it's performer not stored in database
