<?php 
    $stmDep = $pdo_conn->prepare("SELECT * FROM `departemen`");
    $stmDep->execute();
    $rowsDepartemen = $stmDep->fetchAll(PDO::FETCH_ASSOC);
    
    if(isset($_GET['id'])){
        $id = str_replace(date('mYd'),'',$_GET['id']);
        $status = "update";
        $sql = $pdo_conn->prepare("SELECT * FROM budget WHERE idBudget='$id'");
        $sql->execute();
        $getData = $sql->fetch(PDO::FETCH_ASSOC);
    }else{
        $status = "add";
    }
    if(isset($_SESSION['alert'])){
        $message = "";
        if ($_SESSION['alert'] == "gagal") {
            $a = $_SESSION['error'];
            foreach ($a as $data) {
                $message = $message.'<br>'.$data;
            }
        }
        echo "<script>
                Toast.fire({
                    icon: 'error',
                    title: `".$message."`
                })
            </script>";
        unset($_SESSION['alert']);
        unset($_SESSION['error']);
    }
?>
<div style="padding-left:300px; padding-right:300px;" >
    <div class="card o-hidden border-0 shadow-lg">
        <div class="card-body p-0">
            <div class="card-header">
                <h1 class="h4 text-gray-900 text-capitalize">Form <?=$status?> Budget</h1>
            </div>
            <div class="row" style="margin-top: -30px">
                <div class="col-lg-12">
                    <div class="p-5">
                        <form class="user" action="../action/actionBudget.php?status=<?=$status.'&id='.isset($id)?>" method="post">
                            <div class="form-group row">
                                <div class="col-sm-2 offset-sm-3 mb-3 mb-sm-0 text-right mt-3">
                                    <label for="department">Department</label>
                                </div>
                                <div class="col-sm-4">
                                    <select class="form-control form-control-user" name='departemen' id="department" required>
                                        <option value="">Pilih Departemen</option>
                                            <?php foreach ($rowsDepartemen as $rowDepartemen) { ?>
                                                <option value="<?=$rowDepartemen["id_dept"]?>" <?=isset($getData['idDepartment']) ? $getData['idDepartment'] == $rowDepartemen["id_dept"] ? 'selected'  : ''  : '' ?> >
                                                    <?=$rowDepartemen["nama_dept"].'-'.$rowDepartemen["cost_center"]?>
                                                </option>
                                            <?php
                                                }
                                            ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2 offset-sm-3 mb-3 mb-sm-0 text-right mt-3">
                                    <label for="periode">Periode</label>
                                </div>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control form-control-user" placeholder="<?=date('Y') ?>" name="periode" id="periode" required value="<?=isset($getData['periode']) ? $getData['periode'] : '' ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2 offset-sm-3 mb-3 mb-sm-0 text-right mt-3">
                                    <label for="budget">Budget</label>
                                </div>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control form-control-user" placeholder="Insert Budget" name="budget" id="budget" required value="<?=isset($getData['budget']) ? $getData['budget'] : '' ?>">
                                </div>
                            </div>

                            <hr>

                            <div class="form-group row">
                                <div class="col-sm-3 offset-sm-3 mb-3 mb-sm-0 text-right">
                                    <button type="submit" class="btn btn-primary btn-user btn-block"><?=$status=='update' ? 'Save' : 'Tambah Budget' ?></button>
                                </div>
                                <div class="col-sm-3">
                                    <a href="?page=budget" class="btn btn-google btn-user btn-block">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>