<template>
  <div>
      <input v-model="walletCode" placeholder="Enter wallet code">
      <button v-on:click=search()>Search</button>
      <grid :cols="cols" :rows="rows"></grid>
  </div>
</template>

<script>
import axios from '../axios'
import Grid from 'gridjs-vue'

export default {
  name: 'FinancialMovements',
  components: {
    Grid
  },
  data () {
    return {
      walletCode: '',
      cols: [
        'Code movement',
        'Booking date',
        'Description',
        'Amount'
      ],
      rows: []
    }
  },
  methods: {
    formatApiResponse (request) {
      const data = request.data
      if(!data) return
      let output = []
      data.map(row => {
        output.push([
          row.id,
          row.bookingDate,
          row.description,
          `${row.amount.value} ${row.amount.currency}`
        ])
      })

        this.rows = output

      return true
    },
    search () {
      if(!this.walletCode) return false

      axios.get(`/wallets/${this.walletCode}/financial_movements`)
          .then(request => this.formatApiResponse(request))
          .catch(() => this.$router.push('/'))
    }
  }
}
</script>

<style lang="css">
body {
  background: #605B56;
}

.login-wrapper {
  background: #fff;
  width: 70%;
  margin: 12% auto;
}

.form-signin {
  max-width: 330px;
  padding: 10% 15px;
  margin: 0 auto;
}
.form-signin .form-signin-heading,
.form-signin .checkbox {
  margin-bottom: 10px;
}
.form-signin .checkbox {
  font-weight: normal;
}
.form-signin .form-control {
  position: relative;
  height: auto;
  -webkit-box-sizing: border-box;
          box-sizing: border-box;
  padding: 10px;
  font-size: 16px;
}
.form-signin .form-control:focus {
  z-index: 2;
}
.form-signin input[type="username"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}
.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
</style>