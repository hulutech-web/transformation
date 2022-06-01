class Cascader {
    // 处理级联数据格式化，找出
    outputArr = []

    constructor(tree, pathname) {
        this.tree = tree
        this.pathname = pathname
    }

    getNodeRoute(tree, pathname) {
        for (let index = 0; index < tree.length; index++) {
            if (tree[index].children && tree[index].children.length > 0) {
                let endRecursiveLoop = this.getNodeRoute(tree[index].children, pathname)
                if (endRecursiveLoop) {
                    this.outputArr.unshift(tree[index].meta)
                    return true
                }
            }

            if (tree[index].name === pathname) {
                this.outputArr.unshift(tree[index].meta)
                return true
            }
        }
    }
}

export default Cascader
