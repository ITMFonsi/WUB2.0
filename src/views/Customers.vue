<template>
  <v-container
    fill-height
    fluid
    grid-list-xl>
    <v-layout
      justify-center
      wrap
    >

        <v-dialog v-model="dialog" max-width="500px">
          <v-card>
            <v-card-title>
              <span class="headline">Edit Customer</span>
            </v-card-title>

            <v-card-text>
              <v-container grid-list-md>
                <v-layout wrap>
                  <v-flex xs12 sm6 md4>
                    <v-text-field v-model="editedItem.name" label="Name"></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm6 md4>
                    <v-text-field v-model="editedItem.phone1" label="Phone Number"></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm6 md4>
                    <v-text-field v-model="editedItem.mail" label="E-Mail"></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm6 md4>
                    <v-text-field v-model="editedItem.address" label="Adress"></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm6 md4>
                    <v-text-field v-model="editedItem.city" label="City"></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm6 md4>
                    <v-text-field v-model="editedItem.country" label="Country"></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm6 md4>
                    <v-text-field v-model="editedItem.zip" label="Postal Code"></v-text-field>
                  </v-flex>
                </v-layout>
              </v-container>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
              <v-btn color="blue darken-1" text @click="save">Save</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>

<modal height="auto" name="detailsCustomer">
<v-flex
        xs12
        md4
      >
        <material-card class="v-card-profile">
          <v-avatar
            slot="offset"
            class="mx-auto d-block"
            size="130"
          >
            <img
              src="https://demos.creative-tim.com/vue-material-dashboard/img/marc.aba54d65.jpg"
            >
          </v-avatar>
          <v-card-text class="text-xs-center">
            <h6 class="category text-gray font-weight-thin mb-3">CEO / CO-FOUNDER</h6>
            <h4 class="card-title font-weight-light">Alec Thompson</h4>
            <p class="card-description font-weight-light">Don't be scared of the truth because we need to restart the human foundation in truth And I love you like Kanye loves Kanye I love Rick Owens’ bed design but the back is...</p>
            <v-btn
              color="success"
              round
              class="font-weight-light"
            >Follow</v-btn>
          </v-card-text>
        </material-card>
      </v-flex>
</modal>

<modal height="auto" name="createCustomer">
        <material-card
          color="green"
          title="New Customer"
          text="Add a new customer"
        >
          <v-form>
            <v-container py-0>
              <v-layout wrap>
                <v-flex
                  xs12
                  md4
                >
                  <v-text-field
                    class="purple-input"
                    label="Name"
                    v-model="newCustomer.name"
                  />
                </v-flex>
                <v-flex
                  xs12
                  md4
                >
                  <v-text-field
                    class="purple-input"
                    label="Phone Number"
                    v-model="newCustomer.phone1"
                  />
                </v-flex>
                <v-flex
                  xs12
                  md4
                >
                  <v-text-field
                    label="Email Address"
                    class="purple-input"
                    v-model="newCustomer.mail"
                    />
                </v-flex>
                <v-flex
                  xs12
                  md12
                >
                  <v-text-field
                    label="Adress"
                    class="purple-input"
                    v-model="newCustomer.address"/>
                </v-flex>
                <v-flex
                  xs12
                  md4>
                  <v-text-field
                    label="City"
                    class="purple-input"
                    v-model="newCustomer.city"/>
                </v-flex>
                <v-flex
                  xs12
                  md4>
                  <v-text-field
                    label="Country"
                    class="purple-input"
                    v-model="newCustomer.country"/>
                </v-flex>
                <v-flex
                  xs12
                  md4>
                  <v-text-field
                    class="purple-input"
                    label="Postal Code"
                    type="number"
                    v-model="newCustomer.zip"/>
                </v-flex>
                <v-flex
                  xs12
                  text-xs-right
                >
                  <v-btn
                    class="mx-0 font-weight-light"
                    color="success"
                    v-on:click="addCustomer"
                  >
                    Add Customer
                  </v-btn>
                </v-flex>
              </v-layout>
            </v-container>
          </v-form>
        </material-card>
    </modal>

      <v-flex
        md12
      >
        <v-layout>
            <v-flex xs4 order-md1 order-xs3>
                <v-card
                    color="green"
                    dark
                    >
                <v-card-text class="white--text">
                    <div class="headline mb-2">New Customer</div>
                    Click here to add a new customer.
                    </v-card-text>
                    <v-card-actions>
                    <v-btn color="green darken-3" @click="createCustomerModal" text>Add Customer</v-btn>
                    </v-card-actions>
                </v-card>
            </v-flex>
        </v-layout>
    </v-flex>

      <v-flex
        md12
      >
       <material-card
          color="green"
          title="Customers"
          text="List of all customers"
        >
          <v-data-table
            :headers="headers"
            :items="items"
            loading-text="Loading... Please wait"
          >
            <template
              slot="headerCell"
              slot-scope="{ header }"
            >
              <span
                class="font-weight-light text-success text--darken-3"
                v-text="header.text"
              />
            </template>
            <template
              slot="items"
              slot-scope="{ index, item }"
            >
              <td>{{ item.id }}</td>
              <td>{{ item.name }}</td>
              <td>
                  <v-icon
                    small
                    class="mr-2"
                    @click="editItem(item)"
                    >
                        mdi-pencil
                    </v-icon>
                    <v-icon
                        small
                        @click="deleteItem(item)"
                    >
                        mdi-delete
                    </v-icon>
                </td>
            </template>
          </v-data-table>

        </material-card>
               <v-snackbar
              :color="color"
              :bottom="bottom"
              v-model="snackbar"
              dark
            >
              <v-icon
                color="white"
                class="mr-3"
              >
                mdi-bell-plus
              </v-icon>
              <div>{{ this.notificationText }}</div>
              <v-icon
                size="16"
                @click="snackbar = false"
              >
                mdi-close-circle
              </v-icon>
            </v-snackbar>
      </v-flex>
    </v-layout>
    
  </v-container>

  
</template>

<script>
  // axios test
import axios from 'axios'
export default {
methods: {
  createCustomerModal () {
    this.$modal.show('createCustomer');
  },
  hide () {
    this.$modal.hide('createCustomer');
  },
  readCustomers: function() {
    axios
        .get('http://s645270104.online.de/api/customers.php?action=read')
        .then(response => {
        this.items = response.data;
        this.loading = false
        })
        .catch(error => {
        console.log(error)
        })
  },

  addCustomer: function () {
        var formData = this.toFormData(this.newCustomer);
        var me = this;

  		axios.post('http://s645270104.online.de/api/customers.php?action=create', formData)
  		.then(function (response) {
  			if (response.data.error) {
                app.errorMessage = response.data.message;
                me.failed("Customer could not be added!");
  			} else {
                app.successMessage = response.data.message;
                me.success("Customer added successfully!");
  			}
          });

      },

      updateCustomer: function () {
        var me = this;
        var formData = this.toFormData(this.editedItem);
        console.log(this.editedItem);
  		axios.post('http://s645270104.online.de/api/customers.php?action=update', formData)
  		.then(function (response) {
  			if (response.data.error) {
                  app.errorMessage = response.data.message;
                  me.failed("Could not update customer");
                  me.dialog = false;
  			} else {
                  app.successMessage = response.data.message;
                  me.success("Updated customer successfully!");
                  me.dialog = false;
  			}
  		});
      },
      
      deleteCustomer: function (toDelete) {
        var me = this;
        var formData = this.toFormData(toDelete);
  		axios.post('http://s645270104.online.de/api/customers.php?action=delete', formData)
  		.then(function (response) {
  			if (response.data.error) {
                  app.errorMessage = response.data.message;
                  me.failed("Could not delete customer");
  			} else {
  				app.successMessage = response.data.message;
  				me.success("Customer deleted successfully!");
  			}
  		})
  	},
      
      toFormData: function (obj) {
  		var form_data = new FormData();
  		for (var key in obj) {
  			form_data.append(key, obj[key]);
  		}
  		return form_data;
      },
    failed: function(text) {
          this.color = "error";
          this.notificationText = text;
          this.bottom = true
            this.snackbar = true;
            this.hide();
            this.readCustomers();
      },
      success: function(text) {
        this.color = "success";
        this.notificationText = text;
        this.bottom = true
        this.snackbar = true;
        this.hide();
        this.readCustomers();
      },
      editItem: function(item) {
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },
      deleteItem: function(item) {
        confirm('Are you sure you want to delete this customer?') && this.deleteCustomer(item);
      },
      save: function() {
          this.updateCustomer();
      },
      close: function() {
          this.dialog = false
        setTimeout(() => {
          this.editedItem = Object.assign({}, this.newCustomer)
          this.editedIndex = -1
        }, 300)
      },
},

  data () {
    return {
         headers: [
        {
          sortable: false,
          text: '#',
          value: 'id'
        },
        {
          sortable: false,
          text: 'Name',
          value: 'name'
        },
        { 
        text: 'Actions', 
        value: 'action', 
        sortable: false 
        }
      ],
      items: [],
      newCustomer: {
          name: "",
          mail: "",
          phone1: "",
          address: "",
          city: "",
          zip: "",
          country: ""
      },
    editedItem: {
            id: "",
          name: "",
          mail: "",
          phone1: "",
          address: "",
          city: "",
          zip: "",
          country: ""
      },
      loading: true,
      color: null,
      colors: [
      'purple',
      'info',
      'success',
      'warning',
      'error'
    ],
    bottom: false,
    notificationText: "",
    snackbar: false,
    dialog: false
    }
  },
  mounted () {
    this.readCustomers();
  }
}
</script>
