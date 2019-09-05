<?php
  foreach ($dataPengguna as $dPengguna) {
    ?>
    <tr>
      <td><?php echo $dPengguna->username; ?></td>
      <td><?php echo $dPengguna->nama_instansi; ?></td>
      <td class="text-center"><?php echo $dPengguna->nama_role; ?></td>
      <td class="text-center"><?php echo $dPengguna->active; ?></td>
      <td class="text-center" style="min-width: 80px">
        <button class="btn btn-xs btn-success update-dataPengguna" data-id="<?php echo $dPengguna->id; ?>" data-toggle="tooltip" title="Update"><i class="fa fa-pencil"></i></button>

        <button class="btn btn-xs btn-danger konfirmasiHapus-pengguna" data-id="<?php echo $dPengguna->id; ?>" data-toggle="modal" data-target="#konfirmasiHapus" title="Hapus"><i class="fa fa-trash"></i></button>
      </td>
    </tr>
    <?php
  }
?>