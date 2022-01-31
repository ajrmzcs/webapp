<template>
    <div class="content-wrapper">
        <div class="content-body">

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Team Id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Email</th>
                        <th scope="col">Sticky Phone Id</th>
                        <th scope="col">Custom Attributes</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="contact in contacts" :key="contact.id">
                        <td>{{ contact.id }}</td>
                        <td>{{ contact.team_id }}</td>
                        <td>{{ contact.name }}</td>
                        <td>{{ contact.phone }}</td>
                        <td>{{ contact.email }}</td>
                        <td>{{ contact.sticky_phone_number_id }}</td>
                        <td>
                            <tr v-for="custom in contact.custom_attributes">
                                <td>{{ custom.key }} : {{ custom.value }}</td>
                            </tr>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="mt-4 d-flex">
                <button type="button"
                        @click="prevPage"
                        :class="['btn', 'btn-primary', !pagination.prev ? 'disabled' : '']"
                >
                    Prev
                </button>
                <button
                    type="button"
                    @click="nextPage"
                    :class="['btn', 'btn-primary', 'ml-2', !pagination.next ? 'disabled' : '']"
                >
                    Next
                </button>
            </div>
        </div>
    </div>
</template>

<script>

let homeComponent = {
    name: 'ShowRecordsComponent',

    props: [
        'base_url',
    ],

    data() {
        return {
            url: this.base_url+'/records',
            contacts: [],
            pagination: {},
        }
    },

    created() {
        this.importData();
    },

    methods: {
        importData() {
            axios.get(this.url)
                .then(response => {
                    console.log(response.data)
                    this.contacts = response.data.data
                    this.pagination = {
                        prev: response.data.prev_page_url,
                        next: response.data.next_page_url,
                    }
                })
                .catch(error => {
                    alert('Error: '+ error.response.data.error);
                });
        },
        prevPage() {
            if (this.pagination.prev) {
                this.url = this.pagination.prev;
                this.importData();
            }
        },
        nextPage() {
            if (this.pagination.next) {
                this.url = this.pagination.next;
                this.importData();
            }
        }
    },
}

export default homeComponent
</script>
