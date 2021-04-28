package Base;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;
import java.util.logging.Level;
import java.util.logging.Logger;

/**
 *
 * @author wiemhjiri
 */
public class MysqlConnect {
    
    private String url="jdbc:mysql://localhost/pidev";
    private String login="root";
    private String pwd="";
    
    private Connection cnx;
    
    private static MysqlConnect instance;

    private MysqlConnect() {
        try {
            cnx=DriverManager.getConnection(url, login, pwd);
            System.out.println("Connexion");
        } catch (SQLException ex) {
            Logger.getLogger(MysqlConnect.class.getName()).log(Level.SEVERE, null, ex);
        }
    }
    
    public static MysqlConnect getInstance(){
        if(instance==null)
            instance=new MysqlConnect();
        return instance;
    }

    public Connection getConnection() {
        return cnx;
    }
    
    
    
    
    
    
    
}
