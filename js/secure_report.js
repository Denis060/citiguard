document.addEventListener("DOMContentLoaded", () => {
    const firebaseConfig = {
      apiKey: "AIzaSyDOZFKJwKPxXeCdKqtDDrLdS44SgQBNDJw",
      authDomain: "citiguard-reports.firebaseapp.com",
      projectId: "citiguard-reports",
      storageBucket: "citiguard-reports.appspot.com",
      messagingSenderId: "312806894354",
      appId: "1:312806894354:web:d8728cb733ab7ec38961cb"
    };
  
    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
    const db = firebase.firestore();
    const storage = firebase.storage();
  
    const form = document.getElementById("reportForm");
    const formMessage = document.getElementById("formMessage");
  
    form.addEventListener("submit", async (e) => {
      e.preventDefault();
      formMessage.textContent = "Submitting...";
      formMessage.style.color = "#333";
      formMessage.style.fontWeight = "500";
  
      const type = form["type"].value;
      const location = form["location"].value;
      const date = form["date"].value;
      const description = form["description"].value;
      const contact = form["contact"].value;
      const file = form["evidence"].files[0];
  
      let evidenceURL = "";
  
      try {
        if (file) {
          const fileRef = storage.ref(`reports/${Date.now()}_${file.name}`);
          await fileRef.put(file);
          evidenceURL = await fileRef.getDownloadURL();
        }
  
        await db.collection("reports").add({
          type,
          location,
          date,
          description,
          contact,
          evidence: evidenceURL,
          timestamp: firebase.firestore.FieldValue.serverTimestamp(),
          status: "Pending"
        });
  
        formMessage.textContent = "✅ Report submitted successfully.";
        formMessage.style.color = "#28a745";
        formMessage.style.fontWeight = "600";
        form.reset();
      } catch (error) {
        console.error("Error submitting report:", error);
        formMessage.textContent = "⚠️ Failed to submit report. Please try again.";
        formMessage.style.color = "#dc3545";
        formMessage.style.fontWeight = "600";
      }
    });
  });
  