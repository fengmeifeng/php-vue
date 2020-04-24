<!--
 * @Author: fengmeifeng
 * @Date: 2020-04-20 16:12:20
 * @LastEditTime: 2020-04-24 13:46:53
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
			defaultActive: '/index',
			// 页面按钮
			pageBtns: [],
			// 列表按钮
			itemBtns: [],
			// 所有按钮列表
			btns: []
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
			// 执行按钮操作
			this.btnsAssembly(index)
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
			// 赋值itemBtns
			this.btns = await this.deepCopy(data)
			this.$store.commit('useAllBtns', this.btns)
			console.info(this.btns)
		},
		async deepCopy (data) {
      let lists = []
      data.length &&
        data.forEach(el => {
          el.children.forEach(level2 => {
            level2.children.forEach(level3 => {
              lists.push({
                name: level3.name,
                path: level3.path,
                children: level3.children,
                pageBtns: [],
                itemBtns: []
              })
            })
          })
        })
      for (let i = 0; i < lists.length; i++) {
        if (lists[i].children && lists[i].children.length) {
          for (let j = 0; j < lists[i].children.length; j++) {
            if (lists[i].children[j].isbut === 1) {
              lists[i].pageBtns.push(lists[i].children[j])
            } else if (lists[i].children[j].isbut === 2) {
              lists[i].itemBtns.push(lists[i].children[j])
            }
          }
        }
      }
      return lists
		},
		async btnsAssembly (currentPath) {
			console.info(this.$store.getters.allBtns)
			console.info(currentPath)
      this.$store.getters.allBtns.forEach(el => {
        console.info('一动')
        if (currentPath.includes(el.path)) {
          this.$store.dispatch('usingCurrentPageBtns', el.pageBtns)
          this.$store.dispatch('usingCurrentItemBtns', el.itemBtns)
        }
      })
      return true
    }
	},
	mounted () {
		this.menuRequest()
		this.btnsAssembly(this.defaultActive)
	},
	updated () {
    this.defaultActive = window.location.href.split('/#')[1]
  }
}
</script>
<style scoped>

</style>
