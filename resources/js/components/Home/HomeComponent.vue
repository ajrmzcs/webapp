<template>
    <div class="content-wrapper">
        <div class="content-body">
            <div v-if="isUploaderActive" class="d-flex justify-content-center align-items-center" style="height: 90vh">
                <label for="uploader" class="btn btn-success">
                    SELECT CSV
                </label>
                <input type="file" id="uploader" @change="selectFile" ref="uploader" hidden class="d-none"
                accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" />
            </div>
            <div v-if="!isUploaderActive">
                <div class="row mb-5">
                    <div class="col">
                        <h4 class="text-center" v-html="mappertitle"></h4>
                    </div>
                    <div class="col text-center">
                        <a href="javascript:void(0)" class="btn btn-light" @click="isUploaderActive = !isUploaderActive">
                            Upload a different file
                        </a>
                    </div>
                </div>
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Spreadsheet Column #</th>
                            <th scope="col">Database Column Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Column #1</th>
                            <td>
                                <select class="form-control" id="column-1">
                                    <option v-for="item in fields" :value="item">{{ item }}</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Column #2</th>
                            <td>
                                <select class="form-control" id="column-2">
                                    <option v-for="item in fields" :value="item">{{ item }}</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Column #3</th>
                            <td>
                                <select class="form-control" id="column-3">
                                    <option v-for="item in fields" :value="item">{{ item }}</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Column #4</th>
                            <td>
                                <select class="form-control" id="column-4">
                                    <option v-for="item in fields" :value="item">{{ item }}</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Column #5</th>
                            <td>
                                <select class="form-control" id="column-5">
                                    <option v-for="item in fields" :value="item">{{ item }}</option>
                                </select>
                            </td>
                        </tr>
                        <tr v-for="item in customFields">
                            <th>{{ item.spreadsheet }}</th>
                            <td v-html="item.database"></td>
                        </tr>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col">
                        <button class="btn btn-info" @click="addCustomField">
                            Add custom field
                        </button>
                    </div>
                    <div class="col text-center">
                        <button class="btn btn-success" @click="importData">
                            Import All Data
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Resources from './resources';

var homeComponent = {
    name: 'HomeComponent',
    
    data() {
        return {
            isUploaderActive: true,
            fields: Resources.fields,
            contacts: [],
            customFields: [],
            columnsInDatabase: 5,
        }
    },

    methods: {
        selectFile() {
            const validation = validateFile(this.$refs.uploader);
            
            if (! validation.success) {
                this.$refs.uploader.value = null;
                alert(validation.message);
            }
            
            let contacts = [];
            var reader = new FileReader();

            reader.onload = (event) => {
                let lines  = event.target.result.split('\n');
                let columns = [];
                
                for (let i = 0; i < lines.length; i++) {
                    if (lines[i].length) {
                        columns = lines[i].split(',');
                        
                        let jsObj = {};

                        for (let j = 1; j < columns.length; j++) {
                            jsObj[`column-${j}`] = columns[j];
                        }
                        
                        contacts.push(jsObj);
                    }
                }
            }
            
            reader.readAsText(this.$refs.uploader.files[0]);

            reader.onloadend = () => {
                this.contacts = contacts;
                this.showMapper(contacts);
            };

            this.$refs.uploader.value = null;
        },

        showMapper(contacts) {
            this.mappertitle = `Attempting to import ${contacts.length} contacts.`;

            this.isUploaderActive = !this.isUploaderActive;
        },

        addCustomField() {
            this.columnsInDatabase += 1;

            this.customFields.push({
                spreadsheet: `Column #${this.columnsInDatabase}`,
                database: `<input class="form-control" id="column-${this.columnsInDatabase}" />`,
            });
        },

        importData() {
            let columns = {};

            for (let i = 1; i < 6; i++) {
                columns[`column-${i}`] = document.getElementById(`column-${i}`).value;
            }

            for (let i = 6; i < this.customFields.length; i++) {
                columns[`column-${i}`] = document.getElementById(`column-${i}`).value;
            }

            console.log(this.contacts, columns);
            
            this.axios.post('/import', {
                contacts: this.contacts,
                columns: columns
            })
            .then(function (response) {
                alert('Data imported successfully');
            })
            .catch(function (error) {
                alert('Error: '+error);
            });
        }
    },
}

function validateFile(uploader) {
    if (uploader.files.length == 0) {
        return {
            success: false,
            message: 'Please, select a file to import.'
        }
    }

    const extension = uploader.files[0].name.split(".").pop().toLowerCase();

    if (! ['csv'].includes(extension)) {
        return {
            success: false,
            message: 'We only accept CSV files'
        }
    }

    return {
        success: true,
        message: ''
    }
}

export default homeComponent
</script>