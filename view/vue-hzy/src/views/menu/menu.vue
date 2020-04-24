<!--
 * @Author: fengmeifeng
 * @Date: 2020-04-23 09:30:23
 * @LastEditTime: 2020-04-24 15:15:54
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \vue-hzy\src\views\menu\menu.vue
 -->
<template>
  <div>
    <header>
      <el-button type="primary" size="mini" @click="add" class="el-icon-plus m-b-20">
        添加栏目
      </el-button>
    </header>
    <main>
      <el-card>
        <!-- search start -->
        <div class="search m-b-20">
          <el-input
            style="width: 260px;"
            placeholder="栏目名称"
            v-model="searchParam.name"
            class="m-r-10"
            clearable
          ></el-input>
          <el-button
            icon="el-icon-search"
            size="small"
            type="primary"
            @click="search"
          >查询
          </el-button>
          <el-button icon="el-icon-refresh-left" size="small" @click="reset">重置</el-button>
        </div>
        <!-- search end -->
        <main class="m-b-20">
          <el-table :data="lists" style="width: 100%" border stripe size="small">
            <el-table-column
              v-for="{ prop, label, type, width } in tableConfig"
              :key="prop"
              :prop="prop"
              :label="label"
              :type="type"
              :width="width"
            ></el-table-column>
            <el-table-column label="操作" width="260">
              <template slot-scope="scope">
                <el-button
                  @click="handleClick(scope.row, item.scope)"
                  type="text"
                  v-for="(item, index) in itemBtns"
                  :key="index"
                  size="mini"
                  :class="handleClass(item.scope)"
                  >{{ item.name }}</el-button
                >
                <!-- <el-button size="small" type="text" @click="watch(scope.row.name)">查看</el-button> -->
              </template>
            </el-table-column>
          </el-table>
        </main>
        <footer class="flex flex-align-items flex-justify-content">
          <pagination
            :pageNum="pageNum"
            :pageSize="pageSize"
            :totalCount="totalCount"
            @pageBar="getMenuList"
          ></pagination>
        </footer>
      </el-card>
    </main>
    <add ref='addMenu' @lists='getMenuList'></add>
    <edit ref='editMenu' @lists='getMenuList'></edit>
  </div>
</template>
<script>
import pagination from '../../components/pagination/pagination.vue'
import add from './add/add.vue'
import edit from './edit/edit.vue'
import { LISTS, DEL } from '@/api/menu/menu'
import { getRequest, postRequest } from '@/util/ajax'
import { successMessage, errorMessage } from '@/util/message'
import { messageBox } from '@/util/messageBox'
import { handleClass } from '@/util/common'
export default {
  name: 'menuManage',
  components: {
    pagination,
    add,
    edit
  },
  data () {
    return {
      searchParam: {
        name: ''
      },
      pageNum: 1,
      pageSize: 30,
      totalCount: 0,
      lists: [],
      tableConfig: [
        {
          type: 'index',
          label: '序号'
        },
        {
          label: '栏目名称',
          prop: 'name',
          width: 100
        },
        {
          label: '连接地址',
          prop: 'path'
        },
        {
          label: 'icon',
          prop: 'icon'
        },
        {
          label: '英文',
          prop: 'yingwen',
          width: 100
        },
        {
          label: '添加时间',
          prop: 'addTime'
        },
        {
          label: '说明',
          prop: 'remarks'
        }
      ],
      // 页面按钮
      pageBtns: this.$store.getters.currentPageBtns,
      // 列表按钮
      itemBtns: this.$store.getters.currentItemBtns
    }
  },
  methods: {
    // 添加栏目
    add () {
      this.$refs.addMenu.show()
    },
    async getMenuList (pageNum) {
      const params = {
        page: pageNum ? (this.pageNum = pageNum) : this.pageNum,
        pageSize: this.pageSize,
        keyword: this.searchParam.name
      }
      const { code, msg, data } = await getRequest(LISTS, params)
      if (code === 500) {
        return errorMessage(msg)
      }
      this.totalCount = data.total
      this.lists = data.list
    },
    search () {
      this.getMenuList(1)
    },
    reset () {
      this.searchParam.name = ''
      this.getMenuList(1)
    },
    // 增删改查统一处理
    handleClick (row, button) {
      console.info(button)
      switch (button) {
        case 'edit': {
          this.$refs.editMenu.show(row.cid)
          break
        }
        case 'del': {
          this.del(row.cid)
          break
        }
        case 'watch': {
          this.$router.push({
            name: 'menuManageWatch',
            params: { id: row.id }
          })
          break
        }
        default:
          break
      }
    },
    handleClass (button) {
      return handleClass(button)
    },
    // 删除
    async del (id) {
      let title = '删除栏目'
      let content = '是否确定删除该栏目,栏目删除后不可恢复'
      messageBox(content, title, async action => {
        if (action === 'cancel') {
          return
        }
        const { code, msg } = await postRequest(`${DEL}`, {id: id})
        if (code === 500) {
          return errorMessage(msg)
        }
        successMessage(msg)
        this.pageNum = 1
        this.getMenuList()
      })
    }
  },
  mounted () {
    this.getMenuList()
  }
}
</script>
<style lang="less" scoped>
@import '../../assets/styles/less/atom.less';
</style>
