<template>
    <div>
        <admin-layout>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Tickets</h3>
                                    <div class="card-tools" >
                                        <button type="button" class="btn btn-info text-uppercase" style="letter-spacing: 0.1em;" @click="openModal">
                                            Create Tickets
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-nowrap table-dark">
                                        <thead>
                                            <tr>
                                                <th class="text-capitalize">ID</th>
                                                <th class="text-capitalize">Description</th>
                                                <th class="text-capitalize">Assignee</th>
                                                <th class="text-capitalize">Priority</th>
                                                <th class="text-capitalize">Category</th>
                                                <th class="text-capitalize">Creator</th>
                                                 <th class="text-capitalize">Creator Email</th>
                                                <th class="text-capitalize">Created At</th>
                                                <th class="text-capitalize">Status</th>
                                                <th class="text-capitalize text-right">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(ticket, index) in tickets" :key="index">
                                                <td class="text-capitalize">{{ ticket.id }}</td>
                                                <td>{{ ticket.description }}</td>
                                                <td>{{ ticket.assignee }}</td>
                                                <td>{{ ticket.priority }}</td>
                                                <td>{{ ticket.category }}</td>
                                                <td>{{ ticket.name }}</td>
                                                <td>{{ ticket.email }}</td>
                                                <td>{{ ticket.created_at }}</td>
                                                <td>{{ ticket.status }}</td>
                                                <td class="text-right" v-if="$page.props.auth.hasRole.superAdmin || $page.props.auth.hasRole.admin">
                                                    <button class="btn btn-success text-uppercase" style="letter-spacing: 0.1em;" @click="editModal(ticket)">Edit</button>
                                                    <button class="btn btn-danger text-uppercase ml-1" style="letter-spacing: 0.1em;" @click="deleteTicket(ticket)">Delete</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer clearfix">
                                    <!-- <pagination :links="users.links"></pagination> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </section>

                <div class="modal fade" id="modal-lg">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">{{ formTitle }}</h4>
                            <button type="button" class="close" @click="closeModal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body overflow-hidden">
                            <div class="d-flex flex-column h4">
                                <span>Preview: <span class="text-capitalize">{{ form.description }}</span>
                                </span>
                            </div>
                            <div class="card card-primary">
                                <form @submit.prevent="checkMode">
                                    <div class="card-body">
                                        <div class="form-group" v-if="!editMode" >
                                            <label for="name" class="h4">Name</label>
                                            <input type="text" class="form-control" placeholder="Name" v-model="form.name" :class="{ 'is-invalid' : form.errors.name }" autofocus="autofocus" autocomplete="off" required >
                                        </div>
                                        <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.name}">
                                            {{ form.errors.name }}
                                        </div>

                                        <div class="form-group"  v-if="editMode">
                                            <label for="name" class="h4">Name</label>
                                            <input type="text" class="form-control" placeholder="Name" v-model="form.name" :class="{ 'is-invalid' : form.errors.name }" autofocus="autofocus" autocomplete="off" readonly  >
                                        </div>
                                        <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.name}">
                                            {{ form.errors.name }}
                                        </div>

                                        <div class="form-group" v-if="!editMode">
                                            <label for="email" class="h4">E-mail</label>
                                            <input type="email" class="form-control" placeholder="E-mail Address" v-model="form.email" :class="{ 'is-invalid' : form.errors.email }" autocomplete="off"   required>
                                        </div>
                                        <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.email}">
                                            {{ form.errors.email }}
                                        </div>

                                         <div class="form-group" v-if="editMode">
                                            <label for="email" class="h4">E-mail</label>
                                            <input type="email" class="form-control" placeholder="E-mail Address" v-model="form.email" :class="{ 'is-invalid' : form.errors.email }" autocomplete="off" readonly>
                                        </div>
                                        <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.email}">
                                            {{ form.errors.email }}
                                        </div>

                                        <div class="form-group" v-if="!editMode" required>
                                            <div class="form-group">
                                            <label for="category" class="h4">Incident Category</label>
                                            <multiselect
                                                v-model="form.category"
                                                :options="categoryOptions"
                                                :multiple="false"
                                                :taggable="false"
                                                placeholder="Choose Incident Category"
                                            ></multiselect>
                                             </div>
                                        </div>
                                        <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.category}">
                                            {{ form.errors.category }}
                                        </div>

                                        <div class="form-group" v-if="editMode" >
                                            <div class="form-group">
                                            <label for="category" class="h4">Incident Category</label>
                                            <multiselect
                                                v-model="form.category"
                                                :options="categoryOptions"
                                                :multiple="false"
                                                :taggable="false"
                                                :disabled="true"
                                                placeholder="Choose Incident Category"
                                            ></multiselect>
                                             </div>
                                        </div>
                                        <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.category}">
                                            {{ form.errors.category }}
                                        </div>

                                        <div class="form-group" v-if="!editMode" >
                                            <label for="description" class="h4">Incident Description</label>
                                            <input type="text" class="form-control" placeholder="Incident Name" v-model="form.description" :class="{ 'is-invalid' : form.errors.description }" autocomplete="off"  required>
                                        </div>
                                        <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.description}">
                                            {{ form.errors.description }}
                                        </div>

                                        <div class="form-group" v-if="editMode" >
                                            <label for="description" class="h4">Incident Description</label>
                                            <input type="text" class="form-control" placeholder="Incident Name" v-model="form.description" :class="{ 'is-invalid' : form.errors.description }" autocomplete="off" readonly>
                                        </div>
                                        <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.description}">
                                            {{ form.errors.description }}
                                        </div>

                                        <div class="form-group" v-if="!editMode"  required>
                                            <label for="priority" class="h4">Priority</label>
                                            <multiselect
                                                v-model="form.priority"
                                                :options="priorityOptions"
                                                :multiple="false"
                                                :taggable="false"
                                                placeholder="Pick Priority"

                                            ></multiselect>
                                        </div>
                                        <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.priority}">
                                            {{ form.errors.priority }}
                                        </div>

                                        <div class="form-group" v-if="editMode" >
                                            <label for="priority" class="h4">Priority</label>
                                            <multiselect
                                                v-model="form.priority"
                                                :options="priorityOptions"
                                                :multiple="false"
                                                :taggable="false"
                                                :disabled="true"
                                                placeholder="Pick Priority"

                                            ></multiselect>
                                        </div>
                                        <div class="invalid-feedback mb-3" :class="{ 'd-block' : form.errors.priority}">
                                            {{ form.errors.priority }}
                                        </div>



                                        <div class="form-group" v-show="editMode" >
                                            <label for="assignee" class="h4">Assignee</label>
                                            <multiselect
                                                v-model="form.assignee"
                                                :options="assigneeOptions"
                                                :multiple="false"
                                                :taggable="true"
                                                placeholder="Choose assignee"
                                                track-by="name"
                                                label="name"

                                            ></multiselect>
                                        </div>
                                        <div class="invalid-feedback" :class="{ 'd-block' : form.errors.assignee}">
                                            {{ form.errors.assignee }}
                                        </div>

                                        <div class="form-group" v-if="editMode">
                                            <label for="status" class="h4">Status</label>
                                            <multiselect
                                                v-model="form.status"
                                                :options="statusOptions"
                                                :multiple="false"
                                                :taggable="true"
                                                placeholder="choose current status"
                                            ></multiselect>
                                        </div>
                                        <div class="invalid-feedback" :class="{ 'd-block' : form.errors.status}">
                                            {{ form.errors.status }}
                                        </div>
                                    </div>

                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-danger text-uppercase" style="letter-spacing: 0.1em;" @click="closeModal">Cancel</button>
                                        <button type="submit" class="btn btn-info text-uppercase" style="letter-spacing: 0.1em;" :disabled="!form.name || !form.email || !form.category || !form.description || !form.priority || form.processing">{{ buttonTxt }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </admin-layout>
    </div>
</template>

<script>
import AdminLayout from '@/Layouts/AdminLayout'
export default {
     props: ['tickets','assignee'],
     components: {
            AdminLayout,
            //Pagination,
        },
    data() {
            return {
                value:'not assigned',
                editedIndex: -1,
                editMode: false,
                form: this.$inertia.form({
                    id: '',
                    name: '',
                    email: '',
                    category:'',
                    description:'',
                    priority:'',
                    assignee:'',
                    status:'',

                }),
                categoryOptions: ['Network', 'Security', 'Hardware', 'Software', 'Maintainance', 'Email', 'Other'],
                priorityOptions: ['Low', 'Medium', 'High'],
                statusOptions:   ['In progress','Closed'],
                assigneeOptions: this.assignee,
            }
        },

    computed: {

            formTitle() {
                return this.editedIndex === -1 ? 'Create New Ticket' : 'Edit Current Ticket';
            },
            buttonTxt() {
                return this.editedIndex === -1 ? 'Create' : 'Edit';
            },
            checkMode() {
                return this.editMode === false ? this.createTicket : this.editTicket
            }
        },

    methods: {


            editModal(ticket) {
                this.editMode = true
                $('#modal-lg').modal('show')
                this.editedIndex = this.tickets
                this.form.name = ticket.name
                this.form.category = ticket.category
                this.form.description = ticket.description
                this.form.id = ticket.id
                this.form.email = ticket.email
                this.form.priority = ticket.priority
                this.form.assignee = ticket.assignee
                this.form.status = ticket.status
            },
            openModal() {
                this.editedIndex = -1
                $('#modal-lg').modal('show')
            },
            closeModal() {
                this.form.clearErrors()
                this.editMode = false
                this.form.reset()
                $('#modal-lg').modal('hide')
            },
            createTicket() {
                this.form.post(this.route('tickets.store'), {
                    preserveScroll: true,
                    onSuccess:() => {
                        this.closeModal()
                        Toast.fire({
                            icon: 'success',
                            title: 'New Ticket created!'
                        })
                    }
                })
            },
            editTicket() {
                this.form.patch(this.route('tickets.update', this.form.id, this.form), {
                    preserveScroll: true,
                    onSuccess:() => {
                        Toast.fire({
                            icon: 'success',
                            title: 'Ticket has been updated!'
                        })
                        this.closeModal()
                    }
                })
            },
            deleteTicket(ticket) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.form.delete(this.route('tickets.destroy', ticket), {
                            preserveScroll: true,
                            onSuccess: ()=> {
                                Swal.fire(
                                    'Deleted!',
                                    'Ticket has been deleted.',
                                    'success'
                                )
                            }
                        })
                    }
                })
            }
        }

}
</script>
