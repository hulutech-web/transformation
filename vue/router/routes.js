import Home from '../views/Home.vue'
import Show from '../views/Show.vue'
import Cart from '../views/Cart.vue'
const routes = [
    {
        path: "/",
        name: 'home',
        component: Home,
    },
    {
        path: "/goods/:id/show",
        name: 'show',
        component: Show,
    },
    {
        path: "/cart",
        name: 'cart',
        component: Cart,
    }
]

export default routes
