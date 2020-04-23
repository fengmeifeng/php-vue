/*
 * @Author: fengmeifeng
 * @Date: 2020-04-23 09:32:00
 * @LastEditTime: 2020-04-23 09:52:55
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \vue-hzy\src\router\menu\menu.js
 */
const menu = [
  {
    path: 'menu',
    name: 'menuManage',
    component: () =>
      import(
        /* webpackChunkName: "menuManage" */ '../../views/menu/menu.vue'
      ),
    meta: [{ name: '首页', path: '/index' }, { name: '课程资料' }]
  }
]
export default menu
