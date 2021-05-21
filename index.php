<?php
include("consulta.php");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <title>Consultar Endereço</title>
    <meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<!-- Bootstrap -->
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet" />
    
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8 justify-content-center">
                    <div class="card">
                        <div class="card-header text-center">
                            <h3>Consultar Endereço pelo CEP</h3>
                        </div>
                        <div class="card-body form-inline mt-3 mb-3">
                            <form action="" method="post" class="form-inline" >
                                <div class="form-group">
                                    <input type="text" id="cep" name="cep" class="form-control mr-sm-3" placeholder="Digite o CEP" maxlength="9" onkeypress="mascara(this)" required>
                                    <button type="submit" class="btn btn-primary form-control mr-sm-3"> Pesquisar </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-12">
                            <?php echo getEndereco(); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>
        </div>
    </div>
</div>
</body>
<script>
    function mascara(obj) {
        setTimeout(() => {
            obj.value = obj.value.replace(/\D/g,"");
            obj.value = obj.value.replace(/(\d{5})(\d)/, "$1-$2");
        }, 1);
    }
</script>

</html>