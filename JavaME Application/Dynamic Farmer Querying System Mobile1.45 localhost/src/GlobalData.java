/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author jason
 */
public class GlobalData
{
    public DynamicScreen[] appScreens;
    public Response [] responses;
    public String fieldUser;
    public String password;
    public int applicationID;
    public String language;
    public String hostName;
    public Midlet midlet;
    public GlobalData(DynamicScreen[] appScreens,Response[] responses,String fieldUser,String password,String hostName,int applicationID,String language,Midlet midlet)
    {
        this.appScreens=appScreens;
        this.responses=responses;
        this.fieldUser=fieldUser;
        this.password=password;
        this.applicationID=applicationID;
        this.language=language;
        this.hostName=hostName;
        this.midlet=midlet;
    }
}
