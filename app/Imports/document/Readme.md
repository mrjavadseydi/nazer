# Imports

In this directory, we have import excel functions. In all of files that exists in this directory, the columns of excel files was extracted then the main process begins.


## Address Import

The `AddressImport.php` duty is import data to plan address column or update plan's address.

### The Process
We have a loop to extract data row by row. if any error occured, the `try/catch` exception handler, handle it and show the error to you.

First, check to ensure nationality code of current row is not empty.

Second, get all performers that not exists in database and store their to `notFounded` property of this class.

Third, if excel address column is empty then move stored address (`address2`) to `address` column else put excel address into `address` column.

## Area Import

The `AreaImport.php` duty is attach area to plans or update area and plan's area

### The Process
We have a loop to extract data row by row. if any error occured, the `try/catch` exception handler, handle it and show the error to you.

First, check to ensure nationality code of current row is not empty.

Second, get all performers that not exists in database and store their to `notFounded` property of this class.

Third, check the area exists or not. if not exists then store it to database else update it.

Fourth, attach area to plan

## Plan Import

The `PlanImport.php` duty is import plans to database or update plans.

### The Process
We have a loop to extract data row by row. if any error occured, the `try/catch` exception handler, handle it and show the error to you.

First, check to ensure nationality code of current row is not empty.

Second, check if performer exists in database then update it else store it.

Third, Convert arabic ي to ی

Fourth, check if performer's plan not exists then create it else update it.

Fifth, check if supervisor nationality code submiter in excel then assign supervisor to plan
