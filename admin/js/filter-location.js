<script>
  // 🌍 When Region changes, fetch matching districts
  document.getElementById('region').addEventListener('change', function () {
    const regionId = this.value;

    fetch(`controller/get_districts.php?region_id=${regionId}`)
      .then(response => response.json())
      .then(data => {
        const districtDropdown = document.getElementById('district');
        districtDropdown.innerHTML = '<option value="">-- All Districts --</option>';
        data.forEach(district => {
          districtDropdown.innerHTML += `<option value="${district.id}">${district.name}</option>`;
        });
      });
  });

  // 🔁 When District changes, fetch matching chiefdoms
  document.getElementById('district').addEventListener('change', function () {
    const districtId = this.value;

    fetch(`controller/get_chiefdoms.php?district_id=${districtId}`)
      .then(response => response.json())
      .then(data => {
        const chiefdomDropdown = document.getElementById('chiefdom');
        chiefdomDropdown.innerHTML = '<option value="">-- All Chiefdoms --</option>';
        data.forEach(chiefdom => {
          chiefdomDropdown.innerHTML += `<option value="${chiefdom.id}">${chiefdom.name}</option>`;
        });
      });
  });
</script>
