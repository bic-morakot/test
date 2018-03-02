<div class="admin-default-index">
    <h1><?= $this->context->action->uniqueId ?></h1>
    <p>
        This is the view content for action "<?= $this->context->action->id ?>".
        The action belongs to the controller "<?= get_class($this->context) ?>"
        in the "<?= $this->context->module->id ?>" module.
    </p>
    <p>
        You may customize this page by editing the following file:<br>
        <code><?= __FILE__ ?></code>
    </p>
   
    
    <h4>ผู้ใช้งานระบบ</h4>
    <ul>
        <li><a href="/resource/res-users">ผู้ใช้งานระบบ</a></li>
        <li><a href="/resource/res-group">กลุ่มผู้ใช้งานระบบ</a>
            <small class="help help-block">กลุ่มผู้ใช้ตามฝังองค์กรของบริษัท</small></li>
    </ul>
   
    <h4>Logs</h4>
    <ul>
       
        <li><a href="/admin/app-userlog">User log</a></li>
        
    </ul>
</div>
