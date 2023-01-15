<template>
    <div class="card shadow" style="margin-bottom: 10px">
        <div class="container-fluid">
            <div class="card shadow mb-3">
            <div class="card-header py-3">
                <p class="text-primary m-0 fw-bold">User information</p>
            </div>
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label" for="username"><strong>Name</strong></label><input
                                    v-model="FormData.name" type="text" class="form-control" id="username"
                                    placeholder="Name" name="name" />
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label" for="email"><strong>Post-name</strong></label><input
                                    v-model="FormData.postname" type="text" class="form-control" id="email"
                                    placeholder="Post-name" name="postname" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label" for="first_name"><strong>Age</strong></label><input
                                    v-model="FormData.age" type="number" class="form-control" id="first_name"
                                    placeholder="Age" name="age" />
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label" for="last_name"><strong>Birthday</strong></label><input
                                    v-model="FormData.birthday" type="date" class="form-control" id="last_name"
                                    placeholder="Birthday" name="birthday" />
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <button @click.prevent="saveOrUpdate()" class="btn btn-primary btn-sm" type="submit">
                            {{ displayLabel == false ? 'Save Information' : 'Edit Information' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
        </div>

        <div class="container-fluid">
        <div class="card shadow">
            <div class="card-header py-3">
                <p class="text-primary m-0 fw-bold">User Informations</p>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 text-nowrap">
                        <div id="dataTable_length-1" class="dataTables_length" aria-controls="dataTable"><label
                                class="form-label">Show&nbsp;<select class="d-inline-block form-select form-select-sm">
                                    <option value="10" selected="">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>&nbsp;</label></div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-md-end dataTables_filter" id="dataTable_filter-1"><label
                                class="form-label"><input type="search" v-model="search" @keyup="filterData()" class="form-control form-control-sm"
                                    aria-controls="dataTable" placeholder="Search"></label></div> {{show}}
                    </div>
                </div>
                <div class="table-responsive table mt-2" id="dataTable-1" role="grid" aria-describedby="dataTable_info">
                    <table class="table my-0" id="dataTable">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Name</th>
                                <th>Post-name</th>
                                <th>Age</th>
                                <th>Birthday</th>
                                <th style="text-align: center;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(user, index) in users" :key="user.id">
                                <td>{{ index+1 }}</td>
                                <td>{{ user.name }}</td>
                                <td>{{ user.postname }}</td>
                                <td>{{ user.age }}</td>
                                <td>{{ user.birthday }}</td>
                                <td class="d-flex justify-content-between"><a href="#" @click.prevent="updateDatas(user)">Upd</a><a href="#"
                                        @click.prevent="myDelete(user.id)">Del</a></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td><strong>N°</strong></td>
                                <td><strong>Name</strong></td>
                                <td><strong>Post-name</strong></td>
                                <td><strong>Age</strong></td>
                                <td><strong>Birthday</strong></td>
                                <td><strong style="text-align: center;">Action</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="row">
                    <div class="col-md-6 align-self-center">
                    </div>
                    <div class="col-md-6">
                        <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                            <ul class="pagination">
                                <li class="page-item disabled"><a class="page-link" href="#" aria-label="Previous"><span
                                    aria-hidden="true">«</span></a></li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#" aria-label="Next"><span
                                            aria-hidden="true">»</span></a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            users: '',
            url_: "http://localhost/icrud-vue/src/system/class/user.php",
            name: '',
            FormData: {
                id: '',
                name: '',
                postname: '',
                age: '',
                birthday: ''
            },
            displayLabel: false,
            search: ''
        }
    },
    mounted() {
        this.search == '' ? this.display() : this.filterData()
        this.saveOrUpdate ()
        // alert(this.show)
    },
    methods: {
        initValues () {
            this.FormData.id = ''
            this.FormData.name = ''
            this.FormData.postname = ''
            this.FormData.age = ''
            this.FormData.birthday = ''
        },
        filterData () {
            axios.get(this.url_, {
                params: {
                    action: 'select',
                    search: this.search
                }
            })
            .then ((resp) => {
                this.users = resp.data
            })
        },
        display() {
            axios.get(this.url_, {
                params: {
                    action: 'select'
                }
            })
            .then((response) => {
                this.users = response.data
            })
            .catch((error) => {
                console.log(error)
            })
        },
        myDelete(id) {
            axios.get(this.url_, {
                params: {
                    action: 'delete',
                    id: id
                },
            })
            .then((response) => {
                this.users = response.data
            })
            .catch((error) => {
                console.log(error)
            })
        },
        updateDatas (user) {
            this.FormData.id = user.id
            this.FormData.name = user.name
            this.FormData.postname = user.postname
            this.FormData.age = user.age
            this.FormData.birthday = user.birthday
            
            this.displayLabel = true
            
        },
        myUpdate () {
            if (this.displayLabel == true) {
                axios.get(this.url_, {
                    params: {
                        action: 'update',
                        id: this.FormData.id,
                        name: this.FormData.name,
                        postname: this.FormData.postname,
                        age: this.FormData.age,
                        birthday: this.FormData.birthday,
                    }
                })
                .then((response) => {
                    this.users = response.data
                })
                .catch((error) => {
                    console.log(error)
                })
                this.initValues()
            }
        },
        saveOrUpdate () {
            return this.displayLabel == true ? this.myUpdate (this.updateDatas) : this.saveDatas()
        },
        saveDatas () {
            if (this.FormData.name != '' && this.FormData.postname != '' && this.FormData.age != '' && this.FormData.birthday != '')
            {
                axios.get(this.url_, {
                    params: {
                        action: 'create',
                        name: this.FormData.name,
                        postname: this.FormData.postname,
                        age: this.FormData.age,
                        birthday: this.FormData.birthday,
                    }
                })
                .then((response) => {
                    this.users = response.data
                })
                .catch((error) => {
                    console.log(error)
                })
                this.initValues()
            }
        }
    }
}
</script>

<style>

</style>