<template>
  <v-container
    fill-height
    fluid
    grid-list-xl
  >
    <v-layout wrap>
        
      <v-flex
        sm6
        xs12
        md6
        lg3
      >
        <material-stats-card
          color="green"
          icon="mdi-store"
          title="Customers"
          :value="customerCount"
        />
      </v-flex>
      <v-flex
        sm6
        xs12
        md6
        lg3
      >
        <material-stats-card
          color="orange"
          icon="mdi-content-copy"
          title="Products"
          :value="productCount"
        >

        </material-stats-card>
      </v-flex>
      <v-flex
        sm6
        xs12
        md6
        lg3
      >
        <material-stats-card
          color="red"
          icon="mdi-information-outline"
          title="Invoices"
          :value="invoiceCount"
        />
      </v-flex>
      <v-flex
        sm6
        xs12
        md6
        lg3
      >
        <material-stats-card
          color="info"
          icon="mdi-cash"
          title="Revenue"
          :value="revenueSum"
        />
      </v-flex>


              <v-container style="max-width: 500px">
        <v-text-field
          v-model="task"
          label="What are you working on?"
          solo
          @keydown.enter="create"
        >
          <v-fade-transition slot="append">
            <v-icon
              v-if="task"
              @click="create"
            >
              mdi-plus
            </v-icon>
          </v-fade-transition>
        </v-text-field>
      
    
        <v-divider class="mt-3"></v-divider>         

        <v-layout
          my-1
          align-center
        >
          <strong class="mx-3 black--text text--darken-3">
            Open: {{ remainingTasks }}
          </strong>
          
          <!-- Will be fixed for v1.2 -->
          <v-divider vertical></v-divider>
          
          <strong class="mx-3 success--text text--darken-3">
            Completed: {{ completedTasks }}
          </strong>
          
          <v-spacer></v-spacer>
          
          <v-progress-circular
            :value="progress"
            class="mr-2"
            color="green"
          ></v-progress-circular>
        </v-layout>
        
        <v-divider class="mb-3"></v-divider>
        
        <v-card v-if="tasks.length > 0">
          <v-slide-y-transition
            class="py-0"
            group
            tag="v-list"
          >
            <template v-for="(task, i) in tasks">
              
              <v-divider
                v-if="i !== 0"
                :key="`${i}-divider`"
              ></v-divider>
              
              <v-list-tile 
                :key="`${i}-${task.text}`"
                @click="updateTask(task)"
              >
              
                  <v-checkbox
                    v-model="task.done"
                    color="info darken-3"
                  >
                    <div
                      slot="label"
                      :class="task.done && 'grey--text' || 'text--primary'"
                      class="ml-3"
                      v-text="task.text"
                    ></div>
                  </v-checkbox>
                <v-spacer></v-spacer>

                <v-scroll-x-transition>
                  <v-icon
                    v-if="task.done"
                    color="success"
                  >
                    mdi-check
                  </v-icon>
                </v-scroll-x-transition>
                
              </v-list-tile>
                  <v-list-tile 
                    :key="`${i}-${task.text}`"
                    @click="archiveTask(task)"
                  >
                 <p class="card-description font-weight-light text-xs-center" center><v-icon>mdi-archive</v-icon></p>
                    </v-list-tile>
            </template>

          </v-slide-y-transition>
        </v-card>
      </v-container>

      <v-flex
        md12
        lg6
        xs6
      >
                <material-card
          color="red"
          title="Invoice Overview"
          text="Open invoices"
        >
          <v-data-table
            :headers="headersInvoice"
            :items="invoiceItems"
            
          >
            <template
              slot="headerCell"
              slot-scope="{ header }"
            >
              <span
                class="font-weight-light text-warning text--darken-3"
                v-text="header.text"
              />
            </template>
            <template
              slot="items"
              slot-scope="{ index, item }"
            >

              <td>{{ item.invoiceDueDate }}</td>
              <td>{{ item.invoiceNumber }}</td>
              <td>{{ item.invoiceCustomer.name }}</td>
              <td>{{ item.invoiceTotal - item.invoiceSumPaid }} €</td>
            </template>
          </v-data-table>
        </material-card>
        </v-flex>




    </v-layout>
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
  </v-container>

  
</template>

<script>
import firebase from 'firebase'
export default {
  data () {
    return {
      headers: [
        {
          sortable: false,
          text: 'Name',
          value: 'customer'
        },
        {
          sortable: false,
          text: 'Revenue',
          value: 'total',
        }
      ],
            headersInvoice: [
                      {
          sortable: true,
          text: 'Due Date',
          value: 'date'
        },
        {
          sortable: false,
          text: 'Invoice',
          value: 'invoice'
        },
                {
          sortable: false,
          text: 'Customer',
          value: 'customer',
        },
        {
          sortable: false,
          text: 'Balance Due',
          value: 'total',
        }
      ],
      ProductItems: [],
      CustomerItems: [],
      bestCustomers: [],
      invoiceItems:[],
      productCount: '',
      customerCount:'',
      invoiceCount:'0',
      revenueSum:'0',
      tabs: 0,
      list: {
        0: false,
        1: false,
        2: false
      },
      tasks: [],
    task: '',
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
    }
  },
 computed: {
    completedTasks () {
      return this.tasks.filter(task => task.done).length
    },
    progress () {
      return this.completedTasks / this.tasks.length * 100
    },
    remainingTasks () {
      return this.tasks.length - this.completedTasks
    }
  },

  methods: {
    failed: function(text) {
          this.color = "error";
          this.notificationText = text;
          this.bottom = true
          this.snackbar = true;
      },
      success: function(text) {
        this.color = "success";
        this.notificationText = text;
        this.bottom = true
        this.snackbar = true;
      },
        create () {
    var me = this;
    var db = firebase.firestore();
    var todoRef = db.collection("todos");

    todoRef.add({
        done: false,
        text: this.task,
        archive: false
    })
    .then(function(docRef) {
      me.readTasks();
    })
    .catch(function(error) {
      
    });

      this.task = null
    },
    readTasks: function() {
        var me = this;
        var db = firebase.firestore();
        this.tasks = [];

        db.collection("todos").where('archive', '==', false).get().then(function(querySnapshot) {
            querySnapshot.forEach(function(doc) {
                var toAdd = {
                  id: doc.id,
                  done: doc.data().done,
                  text: doc.data().text,
                  archive: doc.data().archive
                }
                me.tasks.push(toAdd);
            });
        });
    },

    updateTask: function(task) {
      var me = this;
      var db = firebase.firestore();
      var todoRef = db.collection("todos").doc(task.id);

      todoRef.set({
        done: task.done,
        text: task.text,
        archive: false
      })
      .then(function(docRef) {
        me.success("Updated task: " + task.text + "!");
      })
      .catch(function(error) {
        me.failed("Updating task failed!");
      });
    },

      archiveTask: function(task) {
      var me = this;
      var db = firebase.firestore();
      var todoRef = db.collection("todos").doc(task.id);

      todoRef.set({
        done: task.done,
        text: task.text,
        archive: true,
      })
      .then(function(docRef) {
        me.success("Task archived!");
        me.readTasks();   
      })
      .catch(function(error) {
        me.failed("Could not archive task")
      });
    },

    complete (index) {
      this.list[index] = !this.list[index]
    },
    readProducts: function() {
        var me = this;
        var db = firebase.firestore();
        this.items = [];

        db.collection("products").get().then(function(querySnapshot) {
            querySnapshot.forEach(function(doc) {
                var toAdd = {
                  id: doc.id,
                  product_nr: doc.data().product_nr,
                  name: doc.data().name,
                  description: doc.data().description,
                  price: doc.data().price
                }
                me.ProductItems.push(toAdd);
            });
            me.productCount = me.ProductItems.length;
        });
      },
  readCustomers: function() {
    var me = this;
    var db = firebase.firestore();
    this.items = [];

    db.collection("customers").get().then(function(querySnapshot) {
        querySnapshot.forEach(function(doc) {
            var toAdd = {
              id: doc.id,
              name: doc.data().name,
              mail: doc.data().mail,
              phone1: doc.data().phone1,
              address: doc.data().address,
              city: doc.data().city,
              zip: doc.data().zip,
              country: doc.data().country
            }
            me.CustomerItems.push(toAdd);
        });
        me.customerCount = me.CustomerItems.length;
    });
  },
  readInvoices: function() {
    var me = this;
    var db = firebase.firestore();
    this.items = [];

    db.collection("invoices").where('invoiceOpen', '==', true).get().then(function(querySnapshot) {
        querySnapshot.forEach(function(doc) {
            var toAdd = {
            id: doc.id,
            invoiceCustomer: doc.data().invoiceCustomer,
            invoiceNumber: doc.data().invoiceNumber,
            invoiceDate: doc.data().invoiceDate,
            invoiceDueDate: doc.data().invoiceDueDate,
            invoiceOpen: doc.data().invoiceOpen,
            invoiceItems: doc.data().invoiceItems,
            invoiceTotalBeforeTax: doc.data().invoiceTotalBeforeTax,
            invoiceTaxSum: doc.data().invoiceTaxSum,
            invoiceTotal: doc.data().invoiceTotal,
            invoiceSumPaid: doc.data().invoiceSumPaid,
            }
            me.invoiceItems.push(toAdd);
        });

        // set invoice count
        me.invoiceCount = me.invoiceItems.length;

        // get sums of invoices
        var revenue = 0;
        me.invoiceItems.map(function(obj){     
          revenue += parseFloat(obj.invoiceTotal);    
        });
        me.revenueSum = revenue.toFixed(2) + ' €';
    });
  },
  getBestCustomer: function() {
    
  },
  getRevenueSum: function() {
    
  },
  getInvoicesByDate: function() {
    
  },
    getYearlyRevenue: function() {

  },
  getColor (status) {
        if (status == 'Ja') return 'green'
        else if (status == 'Nein') return 'red'
        else return 'orange'
      },
  },


    mounted () {
    this.readProducts();
    this.readCustomers();
    this.readInvoices();
    this.getBestCustomer();
    this.getRevenueSum();
    this.getInvoicesByDate();
    this.getYearlyRevenue();
    this.readTasks();
  }
}
</script>
