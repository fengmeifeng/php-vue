/*
 * @Author: fengmeifeng
 * @Date: 2020-04-23 14:21:09
 * @LastEditTime: 2020-04-23 14:22:28
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \vue-hzy\src\util\common.js
 */
export function handleClass (button) {
  let icon = ''
  switch (button) {
    case 'del':
      icon = 'el-icon-delete'
      break
    case 'edit':
      icon = 'el-icon-edit'
      break
    case 'watch':
      icon = 'el-icon-search'
      break
    default:
      icon = 'el-icon-setting'
      break
  }
  return icon
}
