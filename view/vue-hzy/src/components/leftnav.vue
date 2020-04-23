<!--
 * @Author: fengmeifeng
 * @Date: 2020-04-20 16:12:20
 * @LastEditTime: 2020-04-22 16:36:31
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \vue-hzy\src\components\leftnav.vue
 -->
<template>
	<div>
    <el-menu
			:default-openeds="openeds"
			:default-active="defaultActive"
			@select="changeRouter"
			class="el-menu-vertical-demo"
			@open="handleOpen"
			@close="handleClose"
			background-color="#545c64"
			text-color="#fff"
			active-text-color="#ffd04b">
			<el-submenu
				:index="item.index"
				v-for="item in navLists"
				:key="item.index"
			>
				<template slot="title">
					<i :class="item.icon"></i>
					<span slot="title">{{ item.name }}</span>
				</template>
				<el-submenu
					:index="son.index"
					v-for="son in item.children"
					:key="son.index"
				>
					<template solt="title">
						<span slot="title">{{ son.name }}</span>
					</template>
					<el-menu-item
						:index="grandson.path"
						v-for="grandson in son.children"
						:key="grandson.index"
					>
						{{ grandson.name }}
						</el-menu-item>
				</el-submenu>
			</el-submenu>
		</el-menu>
  </div>
</template>
<script>
import { MENU } from '@/api/components/leftnav'
import { getRequest } from '@/util/ajax'
export default {
  name: 'leftnav',
  data () {
    return {
			openeds: [],
			navLists: [],
			defaultActive: '/index'
		}
  },
  methods: {
		handleOpen (key, keyPath) {
			console.log(key, keyPath)
		},
		handleClose (key, keyPath) {
			console.log(key, keyPath)
		},
		changeRouter (index) {
      console.info('路由' + index)
      this.$router.push(index)
		},
		async resolveNeedOpenMenuIndex (menuLists) {
      console.info('菜单啊你到时开啊', menuLists)
      menuLists.length &&
        menuLists.forEach(el => {
          this.openeds.push(el.index)
        })
    },
		async menuRequest () {
      console.info('执行了')
      const { data } = await getRequest(MENU)
			this.navLists = data
			// 展开菜单
			// await this.resolveNeedOpenMenuIndex(this.navLists)
    }
	},
	mounted () {
    this.menuRequest()
	},
	updated () {
    this.defaultActive = window.location.href.split('/#')[1]
  }
}
</script>
<style scoped>

</style>
