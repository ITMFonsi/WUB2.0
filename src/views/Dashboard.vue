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
        />
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
      <v-flex
        md12
        lg6
        xs6
      >
        <material-card
          color="green"
          title="Top 5 Customers"
          text="Customers ordered by revenue"
        >
          <v-data-table
            :headers="headers"
            :items="bestCustomers"
            hide-actions
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
              <td>{{ item.customer }}</td>
              <td>{{ item.total }} €</td>
            </template>
          </v-data-table>
        </material-card>
      </v-flex>
      <v-flex
        md12
        lg6
        xs6
      >
                <material-card
          color="red"
          title="Invoice Stats"
          text="Recent invoices"
        >
          <v-data-table
            :headers="headersInvoice"
            :items="invoices"
            hide-actions
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

             <v-chip tag="td" :color="getColor(item.open)" class="ma-2" dark></v-chip>
              <td>{{ item.date }}</td>
              <td>{{ item.id }}</td>
              <td>{{ item.customer }}</td>
              <td>{{ item.total }} €</td>
            </template>
          </v-data-table>
        </material-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import axios from 'axios'
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
          sortable: false,
          text: 'Status',
          value: 'status',
        },
                      {
          sortable: false,
          text: 'Date',
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
          text: 'Total',
          value: 'total',
        }
      ],
      items: [],
      bestCustomers: [],
      invoices:[],
      productCount: '',
      customerCount:'',
      invoiceCount:'',
      revenueSum:'',
      tabs: 0,
      list: {
        0: false,
        1: false,
        2: false
      }
    }
  },
  methods: {
    complete (index) {
      this.list[index] = !this.list[index]
    },
  readProducts: function() {
      axios
          .get('http://s645270104.online.de/api/products.php?action=read')
          .then(response => {
          this.productCount = response.data.length;
          this.loading = false
          })
          .catch(error => {
          console.log(error)
          })
    },
  readCustomers: function() {
    axios
        .get('http://s645270104.online.de/api/customers.php?action=read')
        .then(response => {
        this.customerCount = response.data.length;
        this.loading = false
        })
        .catch(error => {
        console.log(error)
        })
  },
    readInvoices: function() {
    axios
        .get('http://s645270104.online.de/api/invoices.php?action=read')
        .then(response => {
        this.invoiceCount = response.data.length;
        this.loading = false
        })
        .catch(error => {
        console.log(error)
        })
  },
      getBestCustomer: function() {
    axios
        .get('http://s645270104.online.de/api/invoices.php?action=customerByRevenue')
        .then(response => {
        this.bestCustomers = response.data;
        this.loading = false
        })
        .catch(error => {
        console.log(error)
        })
  },
        getRevenueSum: function() {
    axios
        .get('http://s645270104.online.de/api/invoices.php?action=sumRevenue')
        .then(response => {
        this.revenueSum = parseFloat(response.data["0"]["sum(total)"]).toFixed(2) + ' €';
        this.loading = false
        })
        .catch(error => {
        console.log(error)
        })
  },
  getInvoicesByDate: function() {
    axios
        .get('http://s645270104.online.de/api/invoices.php?action=invoicesByDate')
        .then(response => {
        this.invoices = response.data;
        this.loading = false
        })
        .catch(error => {
        console.log(error)
        })
  },
    getYearlyRevenue: function() {

    axios
        .get('http://s645270104.online.de/api/invoices.php?action=yearlyRevenue')
        .then(response => {
        this.yearlyRevenue = response.data;
        this.yearlyRevenue = this.yearlyRevenue[0];
      
        this.jan = parseFloat(this.yearlyRevenue.jan);
        this.feb = parseFloat(this.yearlyRevenue.feb);
        this.mar = parseFloat(this.yearlyRevenue.mar);
        this.apr = parseFloat(this.yearlyRevenue.apr);
        this.may = parseFloat(this.yearlyRevenue.may);
        this.jun = parseFloat(this.yearlyRevenue.jun);
        this.jul = parseFloat(this.yearlyRevenue.jul);
        this.aug = parseFloat(this.yearlyRevenue.aug);
        this.sep = parseFloat(this.yearlyRevenue.sep);
        this.oct = parseFloat(this.yearlyRevenue.oct);
        this.nov = parseFloat(this.yearlyRevenue.nov);
        this.dez = parseFloat(this.yearlyRevenue.dez);

        this.loading = false
        })
        .catch(error => {
        console.log(error)
        })
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
  }
}
</script>
