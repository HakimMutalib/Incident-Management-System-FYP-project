<template>
    <div>
        <admin-layout>
        <div class="container-fluid">
            <h1>Virus Scanner</h1>
            <div class="text-center">
                <i class="fas fa-desktop fa-10x"></i>
            </div>
            <br><br>
            <div class="text-center">
                <p>Analyze suspicious files, domains, IPs and URLs to detect malware</p>
            </div>
            <br>
            <br>
            <div class="container">
                <div class="mx-auto" style="width: 100;">
                    <label class="form-label" for="customFile"></label>
                    <input type="file" class="form-control" id="customFile" />
                </div>
            </div>
        </div>
        </admin-layout>
    </div>
</template>

<script>
import AdminLayout from '@/Layouts/AdminLayout'

export default{
    components: {
        AdminLayout,
    }
}
</script>