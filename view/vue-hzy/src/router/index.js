/*
 * @Author: your name
 * @Date: 2020-04-20 14:23:11
 * @LastEditTime: 2020-04-21 09:50:05
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \vue-hzy\src\router\index.js
 */
import Vue from 'vue'
import VueRouter from 'vue-router'
// import HelloWorld from '@/components/HelloWorld'
import layout from '@/views/layout/layout.vue'
import login from '@/views/login/login.vue'
import index from '@/views/main/main.vue'
import user from './user/user'

Vue.use(VueRouter)

const routes = [
  // {
  //   path: "/",
  //   redirect: "/login"
  // },
  {
    path: '/login',
    name: 'login',
    component: login
  },
  {
    path: '/',
    name: 'layout',
    component: layout,
    redirect: 'index',
    children: [
      {
        path: 'index',
        name: '首页',
        component: index,
        meta: [{ name: '首页' }]
      },
      ...user
    ]
  }
// eslint-disable-next-line semi
];
const router = new VueRouter({
  routes
})
export default router
// export default new Router({
//   routes: [
//     {
//       path: '/',
//       name: 'Layout',
//       component: Layout,
//       // 嵌套路由
//       children: [
//         {
//           // 这里不设置值，是把main作为默认页面
//           path: '/',
//           name: 'Main',
//           component: Main
//         }
//       ]
//     },
//     {
//       path: '/login',
//       name: 'Login',
//       component: Login
//     },
//     {
//       path: '/hello',
//       name: 'HelloWorld',
//       component: HelloWorld
//     }
//   ]
// })
