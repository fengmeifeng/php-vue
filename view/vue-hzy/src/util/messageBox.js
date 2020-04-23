/*
 * @Author: wangyi
 * @Date: 2019-11-28 14:49:32
 * @LastEditTime: 2020-04-23 14:20:09
 * @LastEditors: Please set LastEditors
 * @Description: messageBox
 * @FilePath: /admin/src/util/messageBox.js
 */
import { MessageBox } from 'element-ui'
export function messageBox (title, subheading, fn) {
  MessageBox.confirm(title, subheading, {
    type: 'warning',
    callback: fn
  })
}
