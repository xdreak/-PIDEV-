/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Stages.Services;

import Base.MysqlConnect;
import Stage.entities.CandidatureStage;
import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javax.mail.Message;
import javax.mail.MessagingException;
import javax.mail.Multipart;
import javax.mail.PasswordAuthentication;
import javax.mail.Session;
import javax.mail.Transport;
import javax.mail.internet.InternetAddress;
import javax.mail.internet.MimeBodyPart;
import javax.mail.internet.MimeMessage;
import javax.mail.internet.MimeMultipart;
import com.google.zxing.BarcodeFormat;
import com.google.zxing.EncodeHintType;
import com.google.zxing.MultiFormatWriter;
import com.google.zxing.client.j2se.MatrixToImageWriter;
import com.google.zxing.common.BitMatrix;
import com.google.zxing.qrcode.decoder.ErrorCorrectionLevel;
import java.io.File;
import java.io.IOException;
import java.util.HashMap;
import java.util.Map;
import java.util.Properties;
import javafx.scene.control.TextField;


/** 
 *
 * @author imote
 */
public class CandidatureStageServices {
    public ObservableList<CandidatureStage> showCandidatures(){
        Connection cnx =null;
        Statement st = null;
        ResultSet rs = null;
        ObservableList<CandidatureStage> liste = FXCollections.observableArrayList();
        String requette = "SELECT * FROM Candidature_Stage";
        
        try {
            cnx = MysqlConnect.getInstance().getConnection();
            st = cnx.createStatement();
            rs = st.executeQuery(requette);
            CandidatureStage CandidatureStages;
            while (rs.next()){
               CandidatureStages = new CandidatureStage(rs.getInt("id"),rs.getInt("id_stage_id"),rs.getString("nom"),rs.getString("prenom"),rs.getString("email"),rs.getInt("age"),rs.getString("commentaire"));
               liste.add(CandidatureStages);
            }
            
           
        } catch (SQLException ex) {
            ex.printStackTrace();
        }finally {
    if (rs != null) {
        try {
            rs.close();
        } catch (SQLException e) { /* Ignored */}
    }
    if (st != null) {
        try {
            st.close();
        } catch (SQLException e) { /* Ignored */}
    }
    }
        return liste;
        
}
    public boolean addCandidatureStage(CandidatureStage a){
        Connection cnx =null;
        Statement st = null;
        String requette = "INSERT INTO Candidature_Stage (id_stage_id,nom,prenom,email,age,commentaire,id) VALUES ('"+a.getId_stage_id()+"','"+a.getNom()+"','"+a.getPrenom()+"','"+a.getEmail()+"','"+a.getAge()+"','"+a.getCommentaire()+"',"+a.getId()+")";
        try {
            cnx = MysqlConnect.getInstance().getConnection();
            st = cnx.createStatement();
            st.executeUpdate(requette);
            return true;
            
           
        } catch (SQLException ex) {
            ex.printStackTrace();
            return false;
        }finally {
    
    if (st != null) {
        try {
            st.close();
        } catch (SQLException e) { /* Ignored */}
    }
    }
        
    }
public boolean updateCandidatureStage(CandidatureStage a){
        Connection cnx =null;
        Statement st = null;
        String requette = "UPDATE Candidature_Stage set id_stage_id="+a.getId_stage_id()+",nom='"+a.getNom()+"',prenom='"+a.getPrenom()+"',email='"+a.getEmail()+"',commentaire='"+a.getCommentaire()+"',age="+a.getAge()+" WHERE id="+a.getId()+"";
        try {
            cnx = MysqlConnect.getInstance().getConnection();
            st = cnx.createStatement();
            st.executeUpdate(requette);
            return true;
            
           
        } catch (SQLException ex) {
            ex.printStackTrace();
            return false;
        }finally {
    
    if (st != null) {
        try {
            st.close();
        } catch (SQLException e) { /* Ignored */}
    }
    }}
        
        public boolean deleteCandidatureStage(CandidatureStage a){
        Connection cnx =null;
        Statement st = null;
        String requette = "DELETE FROM Candidature_Stage WHERE id="+a.getId()+"";
        try {
            cnx = MysqlConnect.getInstance().getConnection();
            st = cnx.createStatement();
            st.executeUpdate(requette);
            return true;
            
           
        } catch (SQLException ex) {
            ex.printStackTrace();
            return false;
        }finally {
    
    if (st != null) {
        try {
            st.close();
        } catch (SQLException e) { /* Ignored */}
    }
    }
        
    }
       public void MailingCS(String to, String A,String B,String path) throws IOException{
        final String username ="imotemri@gmail.com";
        final String password ="nhbifzkjovbnigym";
        String from = "imotemri@gmail.com";
        Properties properties = new Properties();
        properties.put("mail.smtp.auth", "true");
        properties.put("mail.smtp.starttls.enable", "true");
        properties.put("mail.smtp.host", "smtp.gmail.com");
        properties.put("mail.smtp.port", "587");
        Session session = Session.getInstance(properties, new javax.mail.Authenticator(){
        
           protected PasswordAuthentication getPasswordAuthentication(){
               return new PasswordAuthentication(username,password);
           }
        });
        MimeMessage msg =new MimeMessage(session);
        try{
            msg.setFrom(from);
            msg.addRecipient(Message.RecipientType.TO, new InternetAddress(to));
            msg.setSubject("Services Stages E-Mployini");
            msg.setText("Email Body");
            Multipart con = new MimeMultipart();
            MimeBodyPart text =new MimeBodyPart();
            text.setText(" Vous avez postuler au stage avec success! Veuillez présenter ce QRcode le jour de votre entretien.");
            MimeBodyPart img = new MimeBodyPart();
            img.attachFile(path);
            con.addBodyPart(text);
            con.addBodyPart(img);
            msg.setContent(con);
            Transport.send(msg);
            
        }catch(MessagingException e){}
           
               
            }
       public String QR (String A, String B){
       
           try{
            String qrCodeData = "Nom: "+A+"Prénom "+B+"";
            String filePath = "C:\\Users\\imote\\Desktop\\images\\"+A+B+".png";
            String charset = "UTF-8"; // or "ISO-8859-1"
            Map < EncodeHintType, ErrorCorrectionLevel > hintMap = new HashMap < EncodeHintType, ErrorCorrectionLevel > ();
            hintMap.put(EncodeHintType.ERROR_CORRECTION, ErrorCorrectionLevel.L);
            BitMatrix matrix = new MultiFormatWriter().encode(
                new String(qrCodeData.getBytes(charset), charset),
                BarcodeFormat.QR_CODE, 200, 200, hintMap);
            MatrixToImageWriter.writeToFile(matrix, filePath.substring(filePath
                .lastIndexOf('.') + 1), new File(filePath));
            System.out.println("QR Code image created successfully!");
            return filePath;
           }catch (Exception e){return "Erreur";}
      
    }
            
            
           
        
        
        
        
        
        
  
        
    
}
