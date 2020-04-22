/*
 * @Author: fengmeifeng
 * @Date: 2020-04-21 11:01:14
 * @LastEditTime: 2020-04-21 11:01:28
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \vue-hzy\src\util\message.js
 */
import { Message } from 'element-ui'
export function successMessage (text) {
  Message({
    message: text,
    type: 'success'
  })
}
export function errorMessage (text) {
  Message({
    message: text,
    type: 'warning'
  })
}
