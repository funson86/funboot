BaseController
-----------

Table of contents

- common/components/controller/BaseController
- backend/controller/BaseController
- frontend/controller/BaseController
- api/controller/BaseController


> Funboot use some BaseController that extends yii\web\BaseController to define common variable and functions


### common/components/controller/BaseController

Build-in multiple store with variable $store, in beforeAction() specify the store by domain or code, and initialize store settings and some common data.

Build-in $modelClass to specify Model.

Support to redirect with Flash message.

If return an simple return page, use $this->htmlSuccess(); or $this->htmlFailed();

### backend/controller/BaseController

Funboot platform generate code extends backend/controller/BaseController with basic function below, 
You can override beforeEdit function on little modification, or override actionEdit function on big modification.

The auth is judged in beforeAction function

- List actionIndex Normal List Grid or Tree Grid by specify the $style.
- View actionView/ViewAjax View a single data, xxxAjax view in modal
- Create/Update actionEdit/actionEditAjax Creation with no id specified, Update with id specified, xxxAjax is in model
- Update actionEditAjaxField Update data by ajax in list page.
- Update actionEditAjaxStatus Update status by ajax in list page. Enable/Disable
- Delete actionDelete Soft deletion of set status to STATUS_DELETE by default. Support delete tree(delete children also), you can override beforeDeleteModel or afterDeleteModel.
- Clear actionDeleteAll Clear all data in database. you can override beforeDeleteAll or afterDeleteAll
- Export actionExport Export data with fields defined in $exportFields, field can specify type. Support xls, xlsx, csv, html.
- Import actionImportAjax Import data by using xls file, format is same to $exportField, support flip


### frontend/controller/BaseController

Some frontend controls is specified. If multiple language is not supported, set to a certain language by force.

### api/controller/BaseController

> php does not support multiple inheritance, inherit yii/rest/ActiveController to support Restful instead of inherit common/components/controller/BaseController

api/controller/BaseController complete some variable and method same to common/components/controller/BaseController

Data format for return is defined in api/components/response/Serializer

- List GET actionIndex
- View GET actionView
- Create POST actionCreate
- Update PUT actionUpdate
- Delete Delete actionDelete Soft deletion of set status to STATUS_DELETE by default. Support delete tree(delete children also), you can override beforeDeleteModel or afterDeleteModel.


Support $this->success(), $this->error() method for shortcut


