<style type="text/css">
.mzz-debug {
    margin-top: 10px;
  	color: black;
    border: 1px solid #D6D6D6;
    background-color: #FAFAFA;
    font-family: arial, tahoma, verdana;
    font-size: 12px;
    padding: 10px;
    line-height: 140%;
}

.mzz-debug pre {
    white-space: pre-wrap;
}

.mzz-debug-title {
    padding-top: 2px;
    color: #AA0000;
    font-size: 120%;
    font-weight: bold;
}

.mzz-debug-var-title {
    margin: 10px 0;
    font-weight: bold;
    color: black;
    font-size: 
}
</style>

<?php if ($debug_vars) {?>
<div class="mzz-debug">
    <div class="mzz-debug-title">Debug</div>
    <?php foreach ($debug_vars as $var) {?>
    <?php if ($var['title']) {?><div class="mzz-debug-var-title"><?php echo htmlspecialchars($var['title']) ?>:</div><?php }?>
    <pre>
<?php if ($var['rawOutput']) echo $var['value']; else var_dump($var['value']); ?>
    </pre>
    <?php } ?>
</div>
<?php }