function handleToast(icon = 'error', title = 'เกิดข้อผิดพลาด') {
    Toast.fire({
        icon: icon,
        title: title
    }).then(() => window.location.reload())
}
