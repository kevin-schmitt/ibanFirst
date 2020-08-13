import Vue from 'vue'
import VueRouter from 'vue-router'
import Login from '@/components/Login'
import Wallet from '@/components/Wallet'
import FinancialMovements from '@/components/FinancialMovements'

Vue.use(VueRouter)

const routes = [
    {
      path: '/',
      name: 'Login',
      component: Login
    },
    {
      path: '/wallets',
      name: 'Wallets',
      component: Wallet
    },
    {
      path: '/financial_movements',
      name: 'financialMovements',
      component: FinancialMovements
    }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
