/*
 * @Author: fengmeifeng
 * @Date: 2020-04-20 16:48:27
 * @LastEditTime: 2020-04-21 10:05:45
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \vue-hzy\src\router\user\user.js
 */
const user = [
  {
    path: 'personalinfor/baseinfor',
    name: 'userManage',
    component: () =>
      import(
        /* webpackChunkName: "userManage" */ '../../views/user/user.vue'
      ),
    meta: [{ name: '首页', path: '/index' }, { name: '课程资料' }]
  }
]
export default user
