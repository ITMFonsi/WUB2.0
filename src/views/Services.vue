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
              <span class="headline">Edit Service</span>
            </v-card-title>

            <v-card-text>
              <v-container grid-list-md>
                <v-layout wrap>
                  <v-flex xs6 sm6 md4>
                    <v-text-field v-model="editedItem.service" label="Service"></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm12 md12>
                    <v-layout justify-center>
                        <v-date-picker v-model="editedItem.date" no-title></v-date-picker>
                    </v-layout>
                  </v-flex>
                  <v-flex xs12 sm12 md12>
                    <v-text-field v-model="editedItem.amount" label="Amount"></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm6 md4>
                    <v-text-field v-model="editedItem.price" label="Price"></v-text-field>
                  </v-flex>
                </v-layout>
              </v-container>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="green darken-1" text @click="close">Cancel</v-btn>
              <v-btn color="green darken-1" text @click="save">Save</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>


<modal height="auto" name="detailsProduct">
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

<modal height="auto" name="createService">
        <material-card
          color="green"
          title="New Service"
          text="Add a new service"
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
                    label="Service"
                    v-model="newProduct.service"
                  />
                </v-flex>
                <v-flex
                  xs12
                  md4
                >
                  <v-text-field
                    class="purple-input"
                    label="Date"
                    v-model="newProduct.date"
                  />
                </v-flex>
                <v-flex
                  xs12
                  md4
                >
                  <v-text-field
                    label="Amount"
                    class="purple-input"
                    v-model="newProduct.amount"
                    />
                </v-flex>
                <v-flex
                  xs12
                  md12
                >
                  <v-text-field
                    label="Price"
                    class="purple-input"
                    v-model="newProduct.price"/>
                </v-flex>
                <v-flex
                  xs12
                  text-xs-right
                >
                  <v-btn
                    class="mx-0 font-weight-light"
                    color="green darken-1"
                    v-on:click="addService"
                  >
                    Add Service
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
                    <div class="headline mb-2">New Service</div>
                    Click here to add a new service.
                    </v-card-text>
                    <v-card-actions>
                    <v-btn color="green darken-3" @click="createServiceModal" text>Add Service</v-btn>
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
          title="Services"
          text="List of all services"

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
              <td>{{ item.date }}</td>
              <td>{{ item.service }}</td>
              <td>{{ item.price }} €</td>
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
                        class="mr-2"
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
  createServiceModal () {
    this.$modal.show('createService');
  },
  hide () {
    this.$modal.hide('createService');
  },
  readServices: function() {
    axios
        .get('http://s645270104.online.de/api/services.php?action=read')
        .then(response => {
        this.items = response.data;
        this.loading = false
        })
        .catch(error => {
        console.log(error)
        })
  },

  addService: function () {
        var formData = this.toFormData(this.newProduct);
        var me = this;

  		axios.post('http://s645270104.online.de/api/services.php?action=create', formData)
  		.then(function (response) {
  			if (response.data.error) {
                app.errorMessage = response.data.message;
                me.failed("Service could not be added!");
  			} else {
                app.successMessage = response.data.message;
                me.success("Service added successfully!");
  			}
          });

      },

      updateService: function () {
        var me = this;
        var formData = this.toFormData(this.editedItem);
  		axios.post('http://s645270104.online.de/api/services.php?action=update', formData)
  		.then(function (response) {
  			if (response.data.error) {
                  app.errorMessage = response.data.message;
                  me.failed("Could not update service");
                  me.dialog = false;
  			} else {
                  app.successMessage = response.data.message;
                  me.success("Updated service successfully!");
                  me.dialog = false;
  			}
  		});
      },
      
      deleteService: function (toDelete) {
        var me = this;
        var formData = this.toFormData(toDelete);
  		axios.post('http://s645270104.online.de/api/services.php?action=delete', formData)
  		.then(function (response) {
  			if (response.data.error) {
                  app.errorMessage = response.data.message;
                  me.failed("Could not delete service");
  			} else {
  				app.successMessage = response.data.message;
  				me.success("Service deleted successfully!");
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
            this.readServices();
      },
      success: function(text) {
        this.color = "success";
        this.notificationText = text;
        this.bottom = true
        this.snackbar = true;
        this.hide();
        this.readServices();
      },
      editItem: function(item) {
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },
      deleteItem: function(item) {
        confirm('Are you sure you want to delete this service?') && this.deleteService(item);
      },
      save: function() {
          this.updateService();
      },
      close: function() {
          this.dialog = false
        setTimeout(() => {
          this.editedItem = Object.assign({}, this.newProduct)
          this.editedIndex = -1
        }, 300)
      }
},

  data () {
    return {
         headers: [
        {
          sortable: true,
          text: 'Date',
          value: 'date'
        },
        {
          sortable: false,
          text: 'Service',
          value: 'service'
        },
        {
          sortable: true,
          text: 'Price',
          value: 'price'
        },
        { 
        text: 'Actions', 
        value: 'action', 
        sortable: false 
        }
      ],
      items: [],
      newProduct: {
          product_nr: "",
          name: "",
          description: "",
          price: ""
      },
    editedItem: {
            id: "",
          product_nr: "",
          name: "",
          description: "",
          price: ""
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
    dialog: false,
    }
  },
  mounted () {
    this.readServices();
  }
}
</script>
