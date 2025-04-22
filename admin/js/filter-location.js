<script>
  // 🌍 When Region changes, fetch matching districts
  document.getElementById('region').addEventListener('change', function () {
    const region = this.value;

    fetch('controller/get_districts.php?region=' + encodeURIComponent(region))
      .then(response => response.json())
      .then(data => {
        const districtSelect = document.getElementById('district');
        districtSelect.innerHTML = '<option value="">-- All Districts --</option>';
        data.forEach(district => {
          const option = document.createElement('option');
          option.value = district.name;
          option.textContent = district.name;
          districtSelect.appendChild(option);
        });

        // Clear chiefdoms
        document.getElementById('chiefdom').innerHTML = '<option value="">-- All Chiefdoms --</option>';
      });
  });

  // 🔁 When District changes, fetch matching chiefdoms
  document.getElementById('district').addEventListener('change', function () {
    const district = this.value;

    fetch('controller/get_chiefdoms.php?district=' + encodeURIComponent(district))
      .then(response => response.json())
      .then(data => {
        const chiefdomSelect = document.getElementById('chiefdom');
        chiefdomSelect.innerHTML = '<option value="">-- All Chiefdoms --</option>';
        data.forEach(chiefdom => {
          const option = document.createElement('option');
          option.value = chiefdom.name;
          option.textContent = chiefdom.name;
          chiefdomSelect.appendChild(option);
        });
      });
  });
</script>
