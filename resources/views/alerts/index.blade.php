<script type="text/javascript">
  <?php if(session('msgInfo')){?>
    alertify.success('<?=session("msgInfo")?>','20');
  <?php } ?>
  <?php if(session('msgError')){?>
    alertify.error('<?=session("msgError")?>','20');
  <?php } ?>
  <?php if(session('msgWarning')){?>
    alertify.warning('<?=session("msgWarning")?>','20');
  <?php } ?>
</script>